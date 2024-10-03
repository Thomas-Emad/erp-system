<?php

namespace App\Http\Controllers;

use App\Models\SellingReturn;
use App\Models\SellingInvoice;
use App\Models\ProductStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellingReturnController extends Controller
{
    
    public function return($selling_invoice_id) {

        $sellig_invoice = SellingInvoice::findOrFail($selling_invoice_id);
        SellingReturn::create([
            'selling_invoice_id' => $selling_invoice_id,
            'total_price'       => $sellig_invoice->total_price
        ]);

        foreach($sellig_invoice->selling_invoice_products as $selling_invoice_product) {
            
            $selling_invoice_product->product->update([
                'quantity' => $selling_invoice_product->product->quantity + $selling_invoice_product->quantity
            ]);

            $product_store = ProductStore::where('id', $selling_invoice_product->store_id)
                                    ->where('product_id', $selling_invoice_product->product_id)->first();
            $product_store->update([
                'quantity' => $product_store->quantity  + $selling_invoice_product->quantity
            ]);

        }
        
        $sellig_invoice->update([
            'status' => 'closed'
        ]);

        return response()->json([
            'Message' => 'Suc'
        ]);

    }

}
