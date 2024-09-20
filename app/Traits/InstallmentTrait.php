<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Installment;
use App\Models\InstallmentPayment;
use App\Models\RawMaterial;
use App\Models\InstallmentProduct;
use App\Models\Product;
use App\Models\Transaction;
use App\Traits\TransactionTrait;



trait InstallmentTrait
{
  use TransactionTrait;


  /**
   * Choose the model to use based on the type of installment.
   *
   * @param string $type The type of installment (supplier or customer).
   * @return string The class name of the model to use.
   * @throws \Exception If the given type is not supported.
   */
  private function chooseModelProduct($type)
  {
    $modelType = match ($type) {
      "supplier" => RawMaterial::class,
      "customer" => Product::class,
      default => throw new \Exception('Sorry, we not have this Model')
    };
    return $modelType;
  }

  /**
   * Stores an installment based on the provided request and validator data.
   *
   * This function creates a new installment, attaches products to it,
   * synchronizes the products with the repository, stores any attachment,
   * and schedules payments. It also updates the installment with the total
   * cost and attachment information.
   *
   * @param Request $request The request object containing the installment data.
   * @param mixed $validator The validator data for the installment.
   * @param string $type The type of installment (supplier or customer).
   * @throws \Exception If an error occurs during the installment creation process.
   * @return \Illuminate\Http\JsonResponse A JSON response indicating the result of the installment creation.
   */
  protected function storeInstallment(Request $request, $validator, string $type)
  {
    $type == "supplier" ? 'supplier' : 'customer';

    try {
      $installment = Installment::create($validator);
      $products = $this->attachProducts((object) [
        "products" => $request->products,
        "installment_id" => $installment->id,
      ], $type);
      $this->syncProductsWithRepository($request->products, $type, 'decrement');

      // Store Attachment
      if ($request->hasFile('attachment')) {
        $filename = $request->attachment->hashName();
        $request->file("attachment")->storeAs("installments/$type/" . $filename);
      }

      // Store Payments schedule
      $countInstallment = ceil($products->cost / $installment->installment_amount);
      $this->storePayments($installment, $products->cost, $countInstallment);


      // Update Installment
      $installment->update([
        'total_installment' => $products->cost,
        'attachment' =>  $filename,
        'end' => $this->dataPaidInstallment($installment->duration, $installment->start, $countInstallment + 1),
      ]);

      return response()->json([
        'message' => 'Installment was successfully established'
      ], 201);
    } catch (\Exception $e) {
      return response()->json([
        'message' => "Something is wrong!!",
        'error' => $e->getMessage()
      ], 500);
    }
  }


  /**
   * Attaches materials to an installment supplier and calculates the total cost.
   *
   * @param object $request The request object containing the materials to attach.
   * @return object An object containing the total cost of the attached materials.
   */
  protected function attachProducts($request, $type)
  {
    $cost = 0;
    foreach ($request->products as $productInfo) {
      $product = $this->chooseModelProduct($type)::findOrFail($productInfo["id"]);

      if ($product) {
        $cost += $product->price_installment * $productInfo["quantity"];
        InstallmentProduct::create([
          "installment_id" => $request->installment_id,
          "product_id" => $product->id,
          "price" => $product->price_installment,
          "quantity" => (int) $productInfo["quantity"]
        ]);
      }
    }
    return (object) [
      "cost" => $cost
    ];
  }

  protected function syncProductsWithRepository($products, $typeModel, $typeSync)
  {
    foreach ($products as $productInfo) {
      if ($typeSync == 'increment') {
        $this->chooseModelProduct($typeModel)::where('id', $productInfo["id"])->increment('quantity', $productInfo["quantity"]);
      } elseif ($typeSync == 'decrement') {
        $this->chooseModelProduct($typeModel)::where('id', $productInfo["id"])->decrement('quantity', $productInfo["quantity"]);
      }
    }
  }

  /**
   * Calculates the date of the next installment based on the given duration and start date.
   *
   * @param string $duration The duration of the installment (week, month, year).
   * @param string $data The start date of the installment.
   * @param int $addition The number of durations to add to the start date (default is 1).
   * @return Carbon The calculated date of the next installment.
   */
  protected function dataPaidInstallment($duration, $data, $addition = 1)
  {
    $dataPaidInstallment =  match ($duration) {
      'week'  => Carbon::parse($data)->addWeeks($addition),
      'month' => Carbon::parse($data)->addMonths($addition),
      'year'  => Carbon::parse($data)->addYears($addition),
    };

    return $dataPaidInstallment;
  }

  /**
   * Stores the payments for an installment supplier by calculating the amount for each installment.
   *
   * @param object $installment The installment object containing the installment amount and other details.
   * @param float $cost The total cost of the installment.
   * @param int $countInstallment The number of installments.
   * @return void
   */
  protected function storePayments($installment, $cost, $countInstallment)
  {
    $pevTotalInstallment = 0;
    for ($i = 0; $i < $countInstallment; $i++) {
      $amount =  $i < $countInstallment - 1 ?
        $installment->installment_amount : ($cost - $pevTotalInstallment);
      $pevTotalInstallment += $amount;

      InstallmentPayment::create([
        'installment_id' => $installment->id,
        'amount' => $amount,
        'date' =>  $this->dataPaidInstallment($installment->duration, $installment->start, $i + 1),
        'type' => $installment->type,
      ]);
    }
  }

  /**
   * Handles a paid payment installment request by validating the input data,
   * updating the installment and payment records, and storing any attachment.
   *
   * @param Request $request The incoming request containing the installment ID, amount, and attachment.
   * @throws \Exception If an error occurs during the payment processing.
   * @return \Illuminate\Http\JsonResponse A JSON response indicating the payment status.
   */
  public function paidPaymentInstallment(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'installment_id' => 'required|exists:installments,id',
      'amount' => 'required|digits_between:1,10',
      'attachment' => 'nullable|image',
    ]);

    if (!$validator->fails()) {
      try {
        $installment = Installment::with(['payments'])->where('status', 'unpaid')->findOrFail($request->installment_id);
        $payments = $installment->payments()->where('status', 'unpaid')->get();
        $totalPaidByClient = $request->amount + $installment->credit_balance;

        // Add Transaction Payment
        $requestTransaction = new Request([
          'client_id' => $installment->client_id,
          'client_type' => $installment->client_type,
          'amount' => $request->amount,
          'type_transaction' => 'deposit',
          'transaction_category' =>  $installment->client_type == 'customer' ? 'receive_installment' : 'pay_installment'
        ]);
        $this->storeTransaction($requestTransaction);

        // Store attachment
        if ($request->hasFile('attachment')) {
          $filename = $request->attachment->hashName();
          $request->file("attachment")->storeAs("installments/supplier/invoices/" . $filename);
        }

        // Check if the amount is greater than the total amount of the unpaid payments
        foreach ($payments as $payment) {
          if ($payment->amount <= $totalPaidByClient) {
            $payment->update([
              'status' => 'paid',
              'attachment' => $request->hasFile('attachment') ? $filename : null
            ]);
            $totalPaidByClient -= $payment->amount;

            if ($payments->last()->id == $payment->id) {
              $installment->update([
                'status' => 'paid',
              ]);
            }
          } else {
            break;
          }
        }

        $installment->update([
          'credit_balance' => $totalPaidByClient,
        ]);

        return response()->json([
          'message' => 'Payment invoice installment has been paid successfully',
        ], 201);
      } catch (\Exception $e) {
        return response()->json([
          'message' => "Something is wrong!!",
          'error' => $e->getMessage()
        ], 500);
      }
    } else {
      return response()->json([
        "errors" => $validator->errors()
      ], 400);
    }
  }


  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    try {
      $installment = Installment::with('payments')->findOrFail($id);
      $payments = $installment->payments()->where('status', 'paid')->get();
      $products = $installment->type == 'customer' ? $installment->products()->get() : $installment->materials()->get();

      // initialize Products format
      $products = collect($products)->map(function ($item) {
        return ['id' => $item->id, 'quantity' => $item->quantityInstallment];
      });

      // Check if there are unpaid payments, if there are, close the installment
      if ($installment->status == 'paid') {
        return response()->json([
          'message' => 'This installment has been already paid'
        ], 400);
      } else if ($installment->status == 'closed') {
        return response()->json([
          'message' => 'This installment has been already closed'
        ], 400);
      } else {
        if ($payments->count() > 0) {
          $installment->update([
            'status' => 'closed',
          ]);
          $installment->payments()->where('status', 'unpaid')->update([
            'status' => 'closed',
          ]);
        } else {
          // Close the installment, Delete all payments, return count products
          $this->syncProductsWithRepository($products, $installment->type, 'increment');
          $installment->update([
            'status' => 'closed',
          ]);
          $installment->payments()->delete();
        }
      }

      return response()->json([
        'message' => 'This installment has been successfully closed'
      ], 202);
    } catch (\Exception $e) {
      return response()->json([
        'message' => "Something is wrong!!",
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
