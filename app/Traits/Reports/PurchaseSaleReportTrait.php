<?php

namespace App\Traits\Reports;

use App\Models\InstallmentPayment;
use App\Models\SellingInvoice;
use App\Models\BuyingInvoice;
use App\Traits\Reports\ReportMethodsTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

trait PurchaseSaleReportTrait
{
  use ReportMethodsTrait;


  /**
   * Generates a purchase and sales report based on the provided filter date.
   * It calculates total purchases and sales, unpaid purchases and sales, and profit or loss.
   * The result is cached for 5 minutes to improve performance.
   *
   * @param Request $request The HTTP request containing the filter date.
   * @return \Illuminate\Http\JsonResponse The purchase and sales report as a JSON response.
   */
  protected function purchaseSaleReport(Request $request)
  {
    if (!Cache::has('purchaseSaleReport')) {
      $installmentPayment = InstallmentPayment::select('amount', 'status', 'type')->whereBetween('created_at', $this->filterDataBy($request->filterDate))->get();
      $buyingInvoices = BuyingInvoice::select('total_price', 'status')->whereBetween('created_at', $this->filterDataBy($request->filterDate))
        ->get();
      $sellingInvoices = SellingInvoice::select('total_price', 'status')->whereBetween('created_at', $this->filterDataBy($request->filterDate))
        ->get();

      // total purchases and sales
      $resultPurchases =  $installmentPayment->where('type', 'supplier')->where('status', 'paid')->sum('amount')
        + $buyingInvoices->where('status', 'cash')->sum('total_price');
      $resultSales =  $installmentPayment->where('type', 'customer')->where('status', 'paid')->sum('amount')
        + $sellingInvoices->where('status', 'cash')->sum('total_price');

      // unpaid purchases and sales
      $unpaidPurchases = $installmentPayment->where('type', 'supplier')->where('status', 'unpaid')->sum('amount')
        + $buyingInvoices->where('status', 'agel')->sum('total_price');
      $unpaidSales = $installmentPayment->where('type', 'customer')->where('status', 'unpaid')->sum('amount')
        + $sellingInvoices->where('status', 'agel')->sum('total_price');

      // result Json
      $result = [
        'Purchases' => [
          'total_purchases' => $installmentPayment->where('type', 'supplier')->sum('amount')
            + $buyingInvoices->whereIn('status', ['cash', 'close', 'agel'])->sum('total_price'),
          'total_return_purchases' => $installmentPayment->where('type', 'supplier')->where('status', 'closed')->sum('amount')
            + $buyingInvoices->where('status', 'closed')->sum('total_price'),
          'unpaid_purchases' => $unpaidPurchases,
          'result' => $resultPurchases,
        ],
        'Sales' => [
          'total_sales' => $installmentPayment->where('type', 'customer')->sum('amount')
            + $sellingInvoices->whereIn('status', ['cash', 'close', 'agel'])->sum('total_price'),
          'total_return_sales' => $installmentPayment->where('type', 'customer')->where('status', 'closed')->sum('amount')
            + $sellingInvoices->where('status', 'closed')->sum('total_price'),
          'unpaid_sales' => $unpaidSales,
          'result' => $resultSales,
        ],
        'result' => [
          'profitOrLoss' => $resultSales - $resultPurchases,
          'unPaid' => $unpaidSales - $unpaidPurchases,
        ],
      ];

      Cache::set('purchaseSaleReport', $result, 60 * 5);
    } else {
      $result = Cache::get('purchaseSaleReport');
    }


    return response()->json($result);
  }
}
