<?php

namespace App\Http\Controllers\Api;

// use App\Models\SellingInvoice;
// use App\Models\SellingReturn;
// use App\Models\BuyingInvoice;
// use App\Models\BuyingReturn;
// use App\Models\Supplier;
// use App\Models\Installment;
use App\Traits\ReportTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    use ReportTrait;

    public function report() {

        return $this->KeyMetrics();
        
    }

}
