<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductRawMaterial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\RawMaterial;
use App\Models\Machine;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {

    // If Role == Admin
    $products = Product::all();
    return response()->json([
      'message' => 'Suc',
      'data'    => $products
    ]);

    /* ----If Role == Store keeper---- */
    // $store = Store::where('store_keeper', Auth::user()->id)->first();
    // $products = $store->products;
    // return response()->json([
    //     'mesasage' => 'Suc',
    //     'date'     => $products
    // ]);

  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {

    // If Role == Amin
    $validate = Validator::make($request->all(), [
      'name'          => ['required', 'string', 'min:3', 'max:50'],
      'description'   => ['string', 'required', 'min:7', 'max:255'],
      'selling_price' => ['required', 'integer'],
      'cost_price'    => ['required', 'integer'],
      'price_installment' => ['required', 'integer'],
      'profit'        => ['integer'],
      'image'         => ['file', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'required'],
      'machine_id'    => ['integer', 'required', 'exists:machines,id'],
    ]);

    if ($validate->fails()) {
      return response()->json([
        'errors' => $validate->errors()
      ], 400);
    }

    if ($request->hasFile('image')) {

      $file = $request->file('image');
      $path = $file->store('products/images', [
        'disk' => 'public'
      ]);
    }

    $product = Product::create([
      'name'          => $request->name,
      'description'   => $request->description,
      'selling_price' => $request->selling_price,
      'cost_price'    => $request->cost_price,
      'profit'        => $request->profit,
      'image'         => $path,
      'machine_id'    => $request->machine_id,
      'price_installment' => $request->price_installment
    ]);

    foreach ($raw_materials as $raw_material) {

      ProductRawMaterial::create([
        'product_id'               => $product->id,
        'raw_material_id'          => $raw_material,
        'quantity_of_raw_material' => $request->quantity_of_raw_material[$raw_material]
      ]);
    }

    return response()->json([
      'Message' => 'Suc'
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {

    // If Role == Admin
    $product = Product::where('id', $id)->first();
    $raw_materials = $product->raw_materials;
    $stores = $product->stores;
    return response()->json([
      'Message'       => 'Suc',
      'product'       => $product,
      'raw_materials' => $raw_materials,
      'stores'        => $stores
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {

    // if Role == Amin
    $validate = Validator::make($request->all(), [
      'name'          => ['required', 'string', 'min:3', 'max:50'],
      'description'   => ['string', 'required', 'min:7', 'max:255'],
      'selling_price' => ['required', 'integer'],
      'cost_price'    => ['required', 'integer'],
      'profit'        => ['integer'],
      'image'         => ['file', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'required'],
      'machine_id'    => ['integer', 'required']
    ]);

    if ($validate->fails()) {
      return response()->json([
        'errors' => $validate->errors()
      ], 400);
    }

    $item = Product::findOrFail($id);
    Storage::delete($item->image);

    foreach ($item->raw_materials as $raw_material) {

      Material::destroy($raw_material->id);
    }

    if (hasFile('image')) {

      $file = $request->file('image');
      $path = $file->store('products/images', [
        'disk' => 'public'
      ]);
    }

    $product = Product::create([
      'name'          => $request->name,
      'description'   => $request->description,
      'selling_price' => $request->selling_price,
      'cost_price'    => $request->cost_price,
      'profit'        => $request->profit,
      'image'         => 'image',
      'machine_id'    => $request->machine_id
    ]);

    foreach ($raw_materials as $raw_material) {

      ProductRawMaterial::create([
        'product_id'               => $product->id,
        'raw_material_id'          => $raw_material,
        'quantity_of_raw_material' => $request->quantity_of_raw_material['raw_material']
      ]);
    }

    return response()->json([
      'Message' => 'Suc'
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    //
  }
}
