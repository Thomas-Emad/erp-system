<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Salary;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\RawMaterial;
use App\Models\Installment;
use App\Models\BuyingReturn;
use App\Models\SellingReturn;
use App\Models\BuyingInvoice;
use App\Models\SellingInvoice;
use App\Models\InstallmentProduct;
use App\Models\InstallmentPayment;
use App\Models\SellingInvoiceProduct;
use App\Models\BuyingInvoiceRawMaterial;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

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
        $total_sell_return = SellingReturn::sum('total_price') + $total_sales_return_installment;
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

    public function get_report_details() {

        $year  = now()->year;
        $installment_product = InstallmentProduct::whereYear('created_at', $year)      
                                ->whereHas('installment', function (Builder $query) {
                                    $query->whereNot('status', 'closed');
                                })        
                                ->whereHas('installment', function (Builder $query) {
                                    $query->where('type', 'customer');
                                })->sum('quantity');

        $selling_invoice_product = SellingInvoiceProduct::whereYear('created_at', $year)      
                                    ->whereHas('selling_invoice', function (Builder $query) {
                                        $query->whereNot('status', 'closed');
                                    })->sum('quantity');

        $opening_stock_by_sale = Product::sum('quantity') + $selling_invoice_product + $installment_product;

        // ----------
        $installment_product = InstallmentProduct::whereYear('created_at', $year)      
                                ->whereHas('installment', function (Builder $query) {
                                    $query->whereNot('status', 'closed');
                                })        
                                ->whereHas('installment', function (Builder $query) {
                                    $query->where('type', 'supplier');
                                })->sum('quantity');

        $buying_invoice_product = buyingInvoiceRawMaterial::whereYear('created_at', $year)      
                                    ->whereHas('buying_invoice', function (Builder $query) {
                                        $query->whereNot('status', 'closed');
                                    })->sum('quantity');

        $opening_stock_by_purchase = RawMaterial::sum('quantity') + $buying_invoice_product + $installment_product;

        // -----------
        $transactions = Transaction::whereYear('created_at', $year)->where('transaction_type', 'withdraw')->sum('amount');

        // -----------
        $Sales_shipping_cost     = SellingInvoice::whereYear('created_at', $year)->sum('shipping_price');
        $purchases_shipping_cost = BuyingInvoice::whereYear('created_at', $year)->sum('shipping_price');
        $orders_shipping_cost    = Order::whereYear('created_at', $year)->sum('shipping_price');
        $production_shipping_cost = Order::whereYear('created_at', $year)->sum('total_cost');

        // ------------
        $ending_stock_by_sale = Product::sum('quantity');
        $ending_stock_by_purchase = RawMaterial::sum('quantity');

        // ------------
        $total_installment_payment = InstallmentPayment::whereHas('installment', function (Builder $query) {
                                                            $query->where('status', 'open');
                                                        })->whereHas('installment', function (Builder $query) {
                                                            $query->where('type', 'customer');
                                                        })->sum('amount');
        $Total_customer_installment = Installment::where('type', 'customer')->sum('total_installment') - $total_installment_payment;

        return response([
            'opening_stock_by_sale'     => $opening_stock_by_sale,
            'opening_stock_by_purchase' => $opening_stock_by_purchase,
            'total_sell_return'         => $this->KeyMetrics()->original['total_sell_return'],
            'total_purchase_return'     => $this->KeyMetrics()->original['total_purchase_return'],
            'total_salary'              => $this->KeyMetrics()->original['total_salary'],
            'total_sales'               => $this->KeyMetrics()->original['total_sales'],
            'total_purchase'            => $this->KeyMetrics()->original['total_purchase'],
            'transactions'              => $transactions,
            'Sales_shipping_cost'       => $Sales_shipping_cost,
            'purchases_shipping_cost'   => $purchases_shipping_cost,
            'orders_shipping_cost'      => $orders_shipping_cost,
            'production_shipping_cost'  => $production_shipping_cost,
            'ending_stock_by_sale'      => $ending_stock_by_sale,
            'ending_stock_by_purchase'  => $ending_stock_by_purchase,
            'Total_customer_installment'=> $Total_customer_installment
        ]);

    } 

}
