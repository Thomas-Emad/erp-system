<?php

namespace App\Http\Controllers;

use App\Models\ProductStore;
use App\Models\FactoryRawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SwitchController extends Controller
{
    
    public function SwitchBetweenStore(Request $request) {

        $validate = Validator::make($request->all(), [
            'quantity'   => ['required', 'integer'],
            'from_store' => ['required', 'integer', 'exists:stores,id'],
            'to_store'   => ['required', 'integer', 'exists:stores,id'],
            'product_id' => ['required', 'integer', 'exists:products,id']
        ]);
        
        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $product_store = ProductStore::where('id', $request->from_store)->where('product_id', $request->product_id)->first();
        if($request->quantity == $product_store->quantity || $request->quantity < $product_store->quantity) {

            $store = ProductStore::where('id', $request->to_store)->where('product_id', $request->product_id)->first();
            $store->update([
                'quantity' => $store->quantity + $request->quantity,
            ]);

            $product_store->update([
                'quantity' => $product_store->quantity - $request->quantity
            ]);

            return response()->json([
                'message' => 'Suc'
            ]);

        }

        return response()->json([
            'message' => 'Un Suc'
        ]);

    }

    public function SwitchBetweenFactory(Request $request) {

        $validate = Validator::make($request->all(), [
            'quantity'        => ['required', 'integer'],
            'from_factory'    => ['required', 'integer', 'exists:factories,id'],
            'to_factory'      => ['required', 'integer', 'exists:factories,id'],
            'raw_material_id' => ['required', 'integer', 'exists:raw_material,id']
        ]);
        
        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $raw_material_factory = FactoryRawMaterial::where('id', $request->from_factory)->where('raw_material_id', $request->raw_material_id)->first();
        if($request->quantity == $raw_material_factory->quantity || $request->quantity < $raw_material_factory->quantity) {

            $factory = FactoryRawMaterial::where('id', $request->to_factory)->where('raw_material_id', $request->raw_material_id)->first();
            $factory->update([
                'quantity' => $factory->quantity + $request->quantity,
            ]);

            $raw_material_factory->update([
                'quantity' => $raw_material_factory->quantity - $request->quantity
            ]);

            return response()->json([
                'message' => 'Suc'
            ]);

        }

        return response()->json([
            'message' => 'Un Suc'
        ]);

    }

}
