<?php

namespace App\Traits;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


trait TransactionTrait
{
  private function rules()
  {
    return [
      'client_id' => ['nullable', 'integer'],
      'client_type' => ['nullable', 'in:customer,supplier,employee'],
      'amount' => ['required', 'integer'],
      'title' => ['nullable', 'max:50', 'string'],
      'description' => ['nullable', 'string'],
      'transaction_type' => ['required', 'in:withdraw,deposit'],
      'transaction_category' => ['required', 'in:salary,pay_installment,receive_installment,cash,other'],
      'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc', 'max:2048'],
    ];
  }

  protected function storeTransaction(Request $request)
  {

    $validator = Validator::make($request->all(), $this->rules());

    if (!$validator->fails()) {
      try {
        // Upload the file
        $validatedData = $validator->valid();
        if ($request->hasFile('attachment')) {
          $filename = $request->attachment->hashName();
          $request->file('attachment')->storeAs('transactions', $filename);
          $validatedData['attachment'] = $filename;
        }
        $validatedData['owner_id'] = Auth::user()->id;

        Transaction::create($validatedData);
        return response()->json(['message' => 'This Transaction was successfully established'], 201);
      } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 400);
      }
    } else {
      return response()->json(['message' => $validator->errors()], 400);
    }
  }
}
