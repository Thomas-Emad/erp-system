<?php

namespace App\Traits;
use App\Models\Supplier;
use App\Models\Installment;
use App\Models\BuyingReturn;
use App\Models\SellingReturn;
use App\Models\BuyingInvoice;
use App\Models\SellingInvoice;

trait ReportTrait
{
    
    private function KeyMetrics() {

        $month = now()->subDays(30);
        $year  = now()->year;
        // جميع المبيعات المقسطة
        $total_sales_installment            = Installment::where('status', '!=', 'closed')
                                                            ->where('type', 'customer')
                                                            ->sum('total_installment');
        // حميع مرتجع المبيعات المقسطة
        $total_sales_return_installment     = Installment::where('status', 'closed')
                                                            ->where('type', 'customer')
                                                            ->sum('total_installment');
        // جميع المشتريات المقسطة
        $total_purchase_installment         = Installment::where('status', '!=', 'closed')
                                                            ->where('type', 'supplier')
                                                            ->sum('total_installment');
        // جميع مرتجع المشتريات المقسطة 
        $total_purchase_return_installment  = Installment::where('status', 'closed')
                                                            ->where('type', 'supplier')
                                                            ->sum('total_installment');
        // حميع المبيعات المقسطة منذ شهر
        $total_sales_installment_last_month = Installment::whereDate('created_at', '>=', $month)
                                                            ->where('status', '!=', 'closed')
                                                            ->where('type', 'customer')
                                                            ->sum('total_installment');
        // حميع المبيعات المقسطة لهذه السنة
        $total_sales_installment_last_year  = Installment::whereYear('created_at', $year)
                                                            ->where('status', '!=', 'closed')
                                                            ->where('type', 'customer')
                                                            ->sum('total_installment');

        // جميع المبيعات الكاش والاقساط والاجلة
        $total_sales             = SellingInvoice::where('status', '!=', 'closed')
                                    ->sum('total_price') + $total_sales_installment;
        // جميع مرتجع المبيعات الكاش والاقساط والاجلة
        $total_sell_return       = SellingReturn::sum('total_price') + $total_sales_return_installment;
        // حميع المشتريات الكاش والاقساط والاجلة
        $total_purchase          = BuyingInvoice::where('status', '!=', 'closed')
                                    ->sum('total_price') + $total_purchase_installment;
        // جميع مرتجع المشتريات الكاش والاقساط والاجلة
        $total_purchase_return   = BuyingReturn::sum('total_price') + $total_purchase_return_installment;
        // جميع الديون اللي علينا لجميع الموردين
        $total_debtor            = Supplier::sum('debtor');
        // جميع المبيعات اللي منذ شهر الكاش والمقسطة والاجلة
        $total_sales_last_month  = SellingInvoice::whereDate('created_at', '>=', $month)
                                                    ->where('status', '!=', 'closed')
                                                    ->sum('total_price') + $total_sales_installment_last_month;
        // جميع المبيعات اللي في السنة الحالية الكاش والمقسطة والاجلة
        $total_sales_last_year   = SellingInvoice::whereYear('created_at', $year)
                                                    ->where('status', '!=', 'closed')
                                                    ->sum('total_price') + $total_sales_installment_last_year;

        return response()->json([
            'total_sales'            => $total_sales,
            'total_sell_return'      => $total_sell_return,
            'total_purchase'         => $total_purchase,
            'total_purchase_return'  => $total_purchase_return,
            'total_debtor'           => $total_debtor,
            'total_sales_last_month' => $total_sales_last_month,
            'total_sales_last_year'  => $total_sales_last_year
        ]);

    }

}
