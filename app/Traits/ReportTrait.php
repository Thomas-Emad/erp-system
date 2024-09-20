<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Salary;
use App\Models\Product;
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
        //  جميع الاقساط التي يجب على العميل دفعها
        $installments_due = Installment::where('type', 'customer')->where('status', 'open')->count();
        // جميع الفواتير الاجلة التي يجب على العميل دفعها
        $selling_invoices_due = SellingInvoice::where('status', 'agel')->count() + $installments_due;
        // جميع الاقساط التي يجب على العميل دفعها اليوم
        $installments_due_today_for_customers = Installment::where('type', 'customer')
                                                ->whereDate('start', today())
                                                ->where('status', 'open')
                                                ->count();
        // إجمالي سعر الأقساط المستحقة اليوم للعملاء
        $The_total_price_of_installments_due_today_for_customers =  Installment::where('type', 'customer')
                                                                    ->where('status', 'open')
                                                                    ->whereDate('start', today())
                                                                    ->sum('installment_amount');  
        // جميع دفع رواتب هذا الشهر
        $sallary = Salary::whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ])->sum('amount'); 
        //  اجمالي تكلفة رواتب هذا الشهر
        $total_salary = User::sum('wallet') + $sallary;
        //  اجمالي رواتب هذا الشهر الغير مدفوعة
        $total_salary_unpaid = User::sum('wallet');
        // اجمالي عدد المنتجات السليمة
        $total_products_unexpired = Product::where('is_expire', 0)->sum('quantity');
        // جميع المنتجات التي يتم انتهاء صلاحيتها من اليوم الى الشهر القادم
        $product_expired = Product::whereBetween('expire_date', [
            Carbon::today(),
            Carbon::now()->addMonth()
        ])->get();


        return response()->json([
            'total_products_unexpired'                                => $total_products_unexpired,
            'product_expired'                                         => $product_expired,
            'total_salary'                                            => $total_salary,
            'total_salary_unpaid'                                     => $total_salary_unpaid,
            'total_sales'                                             => $total_sales,
            'total_sell_return'                                       => $total_sell_return,
            'total_purchase'                                          => $total_purchase,
            'total_purchase_return'                                   => $total_purchase_return,
            'total_debtor'                                            => $total_debtor,
            'total_sales_last_month'                                  => $total_sales_last_month,
            'total_sales_last_year'                                   => $total_sales_last_year,
            'selling_invoices_due'                                    => $selling_invoices_due,
            'installments_due_today_for_customers'                    => $installments_due_today_for_customers,
            'The_total_price_of_installments_due_today_for_customers' => $The_total_price_of_installments_due_today_for_customers
        ]);

    }

}
