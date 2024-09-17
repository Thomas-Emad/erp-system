<?php

namespace App\Http\Controllers;

use App\Models\BuyingReturn;
use App\Models\BuyingInvoice;
use App\Models\FactoryRawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BuyingReturnController extends Controller
{

    public function return($buying_invoice_id) {

        $buying_invoice = BuyingInvoice::findOrFail($buying_invoice_id);
        BuyingReturn::create([
            'buying_invoice_id' => $buying_invoice_id,
            'total_price'       => $buying_invoice->total_price
        ]);

        foreach($buying_invoice->buying_invoice_raw_materials as $buying_invoice_raw_material) {
            
            $buying_invoice_raw_material->raw_material->update([
                'quantity' => $buying_invoice_raw_material->raw_material->quantity - $buying_invoice_raw_material->quantity
            ]);

            $factory_raw_material = FactoryRawMaterial::where('id', $buying_invoice->factory_id)
                                    ->where('raw_material_id', $buying_invoice_raw_material->raw_material->id)->first();
            $factory_raw_material->update([
                'quantity' => $factory_raw_material->quantity  - $buying_invoice_raw_material->quantity
            ]);

        }
        
        $buying_invoice->update([
            'status' => 'closed'
        ]);

        return response()->json([
            'Message' => 'Suc'
        ]);

    }

}
