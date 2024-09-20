<?php

namespace App\Traits\Reports;

use App\Models\InstallmentProduct;
use App\Models\SellingInvoiceProduct;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Traits\Reports\ReportMethodsTrait;

trait GetTopProductByProfitTrait
{
  use ReportMethodsTrait;

  /**
   * Merges two product tables and returns the top 10 products by profit.
   *
   * @param array $tableOne The first product table.
   * @param array $tableTwo The second product table.
   * @param string $sortByDesc Whether to sort by profit in descending order. Defaults to 'true'.
   * @return \Illuminate\Support\Collection A collection of the top 10 products by profit.
   */
  protected function mergeProducts($tableOne, $tableTwo, $sortByDesc = 'true')
  {
    $products = [];

    foreach ($tableOne as $item) {
      if (in_array($item->product_id, $tableTwo->pluck('product_id')->toArray())) {
        $productInInvoice = $tableTwo->where('product_id', $item->product_id)->first();
        $products[] = [
          'id' => $item->product_id,
          'quantity' => $item->totalQuantityProductOrder + $productInInvoice->totalQuantityProductOrder,
          'profit' => $item->profit + $productInInvoice->profit,
          'product' => $item->product
        ];
      } else {
        $products[] = [
          'id' => $item->product_id,
          'quantity' => $item->totalQuantityProductOrder,
          'profit' => $item->profit,
          'product' => $item->product
        ];
      }
    }

    if ($sortByDesc == 'true') {
      $productsCollection = collect($products)->sortByDesc('profit');
    } else {
      $productsCollection = collect($products)->sortBy('profit');
    }

    return $productsCollection->take(10);
  }

  /**
   * Retrieves the top products based on their profit from both installments and invoices.
   *
   * @param Request $request The HTTP request object.
   * @return Collection The collection of top products with their quantity and profit.
   */
  protected function topProductsReport(Request $request)
  {
    // get Products for installments With his Profit
    $productsInstallment = InstallmentProduct::with('product')
      ->whereHas('installment', function (Builder $query) {
        $query->whereIn('status', ['open', 'paid']);
      })
      ->select(
        'product_id',
        DB::raw('SUM(quantity) as totalQuantityProductOrder'),
        DB::raw('SUM((price - (SELECT cost_price FROM products WHERE products.id = installment_products.product_id)) * quantity) as profit')
      )
      ->groupBy('product_id')
      ->whereBetween('created_at', $this->filterDataBy($request->filterDate))
      ->orderBy('profit', 'asc')
      ->get();

    // get Products for Invoices With his Profit
    $productsInvoice = SellingInvoiceProduct::with('product')
      ->whereHas('selling_invoice', function (Builder $query) {
        $query->whereNot('status', 'closed');
      })
      ->select(
        'product_id',
        DB::raw('SUM(quantity) as totalQuantityProductOrder'),
        DB::raw('SUM((price - (SELECT cost_price FROM products WHERE products.id = selling_invoice_products.product_id)) * quantity) as profit')
      )
      ->groupBy('product_id')
      ->whereBetween('created_at', $this->filterDataBy($request->filterDate))
      ->orderBy('profit', 'asc')
      ->get();

    return $this->mergeProducts($productsInstallment, $productsInvoice,  $request->order_by_desc);
  }
}
