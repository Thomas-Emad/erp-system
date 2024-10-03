<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\SellingInvoice;
use App\Models\SellingInvoiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellingInvoiceController extends Controller
{
    
    public function CreateSellingInvoice(Request $request) {
        
        $validate = Validator::make($request->all(), [
            'status'             => ['required'],
            'customer_id'        => ['exists:customers,id']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        SellingInvoice::create([
            'status'      => $request->status,
            'customer_id' => $request->customer_id,
        ]);

        return response()->json([
            'message' => 'Suc'
        ]);

    }

    public function AddProductInInvoice(Request $request, $selling_invoice_id) {

        $validate = Validator::make($request->all(), [
            'quantity'           => ['required', 'integer'],
            'store_id'           => ['exists:stores,id'],
            'product_id'         => ['exists:products,id']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $product_store = ProductStore::where('product_id', $request->product_id)
                        ->where('store_id', $request->store_id)->first();

        if($product_store->quantity == $request->quantity || $product_store->quantity > $request->quantity) {

            $product = Product::findOrFail($request->product_id);
            $selling_invoice = SellingInvoice::findOrFail($selling_invoice_id);
            $selling_invoice_product = SellingInvoiceProduct::create([
                'quantity'           => $request->quantity,
                'price'              => $product->selling_price * $request->quantity,
                'store_id'           => $request->store_id,
                'product_id'         => $request->product_id,
                'selling_invoice_id' => $selling_invoice_id
            ]);

            if($selling_invoice->status == 'agel') {

                $customer = Customer::findOrFail($selling_invoice->customer_id);
                $customer->update([
                    'creditor' =>  $supplier->creditor + $selling_invoice_product->price
                ]);
    
            }

            $selling_invoice->update([
                'total_price' => $selling_invoice->total_price + $selling_invoice_product->price
            ]);

            $product_store->update([
                'quantity' => $product_store->quantity - $request->quantity
            ]);

            $product->update([
                'quantity' => $product->quantity - $request->quantity
            ]);

            return response()->json([
                'message' => 'Suc'
            ]);

        } else {

            return response()->json([
                'message' => 'The Quantity Is Not Avvilable'
            ]);

        }

    }

    public function DeleteProductFromSellingInvoice($selling_invoice_product_id) {

        $selling_invoice_product = SellingInvoiceProduct::FindOrFail($selling_invoice_product_id);

        $product_store = ProductStore::where('store_id', $selling_invoice_product->store_id)
                        ->where('product_id', $selling_invoice_product->product_id)->first();
        $product_store->update([
            'quantity' => $product_store->quantity + $selling_invoice_product->quantity
        ]);

        $product = Product::findOrFail($selling_invoice_product->product_id);
        $product->update([
            'quantity' => $product->quantity + $selling_invoice_product->quantity
        ]);

        $selling_invoice_product->selling_invoice->update([
            'total_price' => $selling_invoice_product->selling_invoice->total_price - $selling_invoice_product->price
        ]);

        $selling_invoice_product->delete();
        
        return response()->json([
            'message' => 'Suc'
        ]);
        
    }

}
