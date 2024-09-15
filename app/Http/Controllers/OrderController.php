<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\OrderProduct;
use App\Models\ProductRawMaterial;
use App\Models\FactoryRawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;        

class OrderController extends Controller
{
    
    public function CraeteOrder(Request $request) {

        $validate = Validator::make($request->all(), [
            'time'       => ['required', 'date'],
            'status'     => ['required', 'in:waiting,working,delivered'],
            'store_id'   => ['required', 'exists:stores,id'],
            'factory_id' => ['required', 'exists:factories,id']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        Order::create([
            'time' => $request->time,
            'status' => $request->status,
            'store_id' => $request->store_id,
            'factory_id' => $request->factory_id
        ]);

        return response()->json([
            'message' => 'Suc'
        ]);

    }

    public function AddProductInOreder(Request $request, $order_id) {

        $validate = Validator::make($request->all(), [
            'quantity'   => ['required', 'integer'],
            'product_id' => ['required', 'exists:products,id']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $order = Order::findOrFail($order_id);
        $product = Product::findOrFail($request->product_id);
        $product_raw_materials = ProductRawMaterial::where('product_id', $request->product_id)->get();
        foreach($product_raw_materials as $product_raw_material) {

            // جبت المادة الخام اللي هنستخدمها في بناء منتج لجلب الكمية المتوفرة في المصنع
            $factory_raw_material = FactoryRawMaterial::where('raw_material_id', $product_raw_material->id)
                                    ->where('factory_id', $order->factory_id)->first();

            // لو كمية المادة الخام اللي هنعمل بيها المنتج غير متوفرة في هذا المصنع سيظهر ايرور
            if( ($product_raw_material->quantity_of_raw_material * $request->quantity) !=  $factory_raw_material->quantity || ($product_raw_material->quantity_of_raw_material * $request->quantity) >  $factory_raw_material->quantity ) {

                return response()->json([
                    'message' => 'There is not enough quantity'
                ]);

            }

            // ضفت جميع المواد الخام التي يتم استخدامها والكميات التي تم استخدامها لكي انقصها من الكمية 
            $id_from_factory_raw_materials[$product_raw_material->quantity_of_raw_material * $request->quantity] = $factory_raw_material->id;
        

        }

        $order_product = OrderProduct::create([
            'quantity'   => $request->quantity,
            'cost'       => $product->cost_price * $request->quantity,
            'product_id' => $request->product_id,
            'order_id'   => $order_id
        ]);

        foreach($id_from_factory_raw_materials as $quantity_of_raw_material => $id_from_factory_raw_material) {

            $quantity_from_factory_raw_material = FactoryRawMaterial::findOrFail($id_from_factory_raw_material);

            // انقص من كمية المادة الخام التي تم استخدامها من هذا المصنع
            $quantity_from_factory_raw_material->update([
                'quantity' => $quantity_from_factory_raw_material->quantity - $quantity_of_raw_material
            ]);

            // انقص من كمية المادة الخام التي تم استخدامها
            $quantity_from_factory_raw_material->raw_material->update([
                'quantity' => $quantity_from_factory_raw_material->raw_material->quantity - $quantity_of_raw_material
            ]);

        }
     
        $order->update([
            'total_cost' => $order->total_cost + $order_product->cost
        ]);

        return response()->json([
            'message' => 'Suc'
        ]);

    }

    public function DeliveryOfTheOrder(Request $request, $order_id) {

        $validate = Validator::make($request->all(), [
            'status' => ['required', 'in:waiting,delivered']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        if($request->status == 'delivered') {

            $order = Order::findOrFail($order_id);
            $order->update([
                'status' => 'delivered'
            ]);

            $order_products = $order->order_products;
            foreach($order_products as $order_product) {

                $product = Product::findOrFail($order_product->product_id);
                $product_store = ProductStore::where('product_id', $order_product->product_id)
                                ->where('store_id', $order->store_id)->first();
                             
                if($product_store) {

                    $product_store->update([
                        'quantity' => $product_store->quantity + $order_product->quantity
                    ]);

                } else {

                    ProductStore::create([
                        'quantity'   => $order_product->quantity,
                        'product_id' => $order_product->product_id,
                        'store_id'   => $order->store_id
                    ]);

                }

                $product->update([
                    'quantity' => $product->quantity + $order_product->quantity
                ]);

            }

            return response()->json([
                'message' => 'Suc'
            ]);

        }

        return response()->json([
            'message' => 'UnSuc'
        ]);


    }

}
