<?php

namespace App\Http\Controllers\Api;

use App\Traits\ReportTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Reports\GetTopProductByProfitTrait;

class ReportsController extends Controller
{
  
  use GetTopProductByProfitTrait, ReportTrait;


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
      return  $this->topProducts($request);
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  public function report()
  {

    return $this->KeyMetrics();

  }

}
