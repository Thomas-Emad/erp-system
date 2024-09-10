<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\RawMaterial;
use App\Models\BuyingInvoice;
use App\Models\FactoryRawMaterial;
use App\Models\BuyingInvoiceRawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BuyingInvoiceController extends Controller
{

    public function CreateBuyingInvoice(Request $request) {

        $validate = Validator::make($request->all(), [
            'status'             => ['required'],
            'factory_id'         => ['exists:factories,id'],
            'supplier_id'        => ['exists:suppliers,id']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        BuyingInvoice::create([
            'status'      => $request->status,
            'factory_id'  => $request->factory_id,
            'supplier_id' => $request->supplier_id
        ]);

        return response()->json([
            'message' => 'Suc'
        ]);

    }

    public function AddRawMaterialInInvoice(Request $request, $buying_invoice_id) {

        $validate = Validator::make($request->all(), [
            'quantity'          => ['required', 'integer'],
            'raw_material_id'   => ['exists:raw_materials,id']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $buying_invoice = BuyingInvoice::findOrFail($buying_invoice_id);
        $raw_material   = RawMaterial::findOrFail($request->raw_material_id);
        $factory_raw_material = FactoryRawMaterial::where('raw_material_id', $request->raw_material_id)
                                ->where('factory_id', $buying_invoice->factory_id)->first();
        if($factory_raw_material) {

            $factory_raw_material->update([
                'quantity' => $factory_raw_material->quantity + $request->quantity
            ]);

        } else {

            FactoryRawMaterial::create([
                'quantity'         => $request->quantity,
                'raw_material_id'  => $request->raw_material_id,
                'factory_id'       => $buying_invoice->factory_id
            ]);
            
        }

        $buying_invoice_raw_material = BuyingInvoiceRawMaterial::create([
            'quantity'         => $request->quantity,
            'price'            => $raw_material->price * $request->quantity,
            'buying_invoice_id' => $buying_invoice_id,
            'raw_material_id'  => $request->raw_material_id
        ]);

        if($buying_invoice->status == 'agel') {

            $supplier = Supplier::findOrFail($buying_invoice->supplier_id);
            $supplier->update([
                'debtor' =>  $supplier->debtor + $buying_invoice_raw_material->price
            ]);

        }

        $buying_invoice->update([
            'total_price' => $buying_invoice->total_price + $buying_invoice_raw_material->price
        ]);

        $raw_material->update([
            'quantity' => $raw_material->quantity + $request->quantity
        ]);

        return response()->json([
            'message' => 'Suc'
        ]);

    }

    public function DeleteRawMaterialFromBuyingInvoice($buying_invoice_raw_material_id) {

        $buying_invoice_raw_material = BuyingInvoiceRawMaterial::FindOrFail($buying_invoice_raw_material_id);

        $factory_raw_material = FactoryRawMaterial::where('factory_id', $buying_invoice_raw_material->buying_invoice->factory_id)
                                ->where('raw_material_id', $buying_invoice_raw_material->raw_material_id)->first();
        $factory_raw_material->update([
            'quantity' => $factory_raw_material->quantity - $buying_invoice_raw_material->quantity
        ]);

        $raw_material = RawMaterial::findOrFail($buying_invoice_raw_material->raw_material_id);
        $raw_material->update([
            'quantity' => $raw_material->quantity - $buying_invoice_raw_material->quantity
        ]);

        $buying_invoice_raw_material->buying_invoice->update([
            'total_price' => $buying_invoice_raw_material->buying_invoice->total_price - $buying_invoice_raw_material->price
        ]);

        $buying_invoice_raw_material->delete();
        
        return response()->json([
            'message' => 'Suc'
        ]);

    }

}
