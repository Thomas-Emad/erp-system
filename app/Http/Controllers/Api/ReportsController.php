<?php

namespace App\Http\Controllers\Api;

use App\Traits\ReportTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Reports\{GetTopProductByProfitTrait, PurchaseSaleReportTrait};

class ReportsController extends Controller
{

  use GetTopProductByProfitTrait, ReportTrait, PurchaseSaleReportTrait;


  /**
   * Retrieves the top products by profit.
   *
   * @param Request $request The incoming HTTP request.
   * @throws \Exception If an error occurs while processing the request.
   * @return \Illuminate\Http\JsonResponse A JSON response containing the top products or an error message.
   */

  public function topProductsByProfit(Request $request)
  {
    try {
      return  $this->topProductsReport($request);
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  public function report() {

    return $this->KeyMetrics();

  }

  public function report_details() {

    return $this->get_report_details();

  }

  /**
   * Generates a purchase sale report based on the provided request.
   *
   * @param Request $request The incoming HTTP request containing parameters for the report.
   * @return mixed The generated purchase sale report.
   */
  public function purchaseSale(Request $request)
  {
    return $this->purchaseSaleReport($request);
  }
}
