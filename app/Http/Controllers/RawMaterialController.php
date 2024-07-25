<?php

namespace App\Http\Controllers;

use App\Models\Factory;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        // If Role == Admin
        $raw_materials = RawMaterial::all();
        return response()->json([
            'message' => 'Suc',
            'data'    => $raw_materials
        ]);

        /* -------If Role == Factory Manager------- */
        // $factory = Factory::where('manager_id', Auth::user()->id)->first();
        // $raw_materials = $factory->raw_materials;
        // return response()->json([
        //     'message' => 'Suc',
        //     'data'    => $raw_materials
        // ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        //If Role == Admin
        $validate = Validator::make($request->all(), [
            'name'        => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'text'],
            'price'       => ['string', 'required']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        RawMaterial::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price
        ]);

        return response()->json([
            'message' => 'Suc'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
        //If Role == Admin
        $raw_material  = RawMaterial::findOrFail($id);
        $products      = $raw_material->products;
        $factories     = $raw_material->factories;
        $machines      = $raw_material->machines;
        return response()->json([
            'Message'      => 'Suc',
            'raw_material' => $raw_material,
            'products'     => $products,
            'factories'    => $factories,
            'machines'     => $machines
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        //If Role == Admin
        $validate = Validator::make($request->all(), [
            'name'        => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'text'],
            'price'       => ['string', 'required']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        RawMaterial::findOrFail($id)->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price
        ]);

        return response()->json([
            'message' => 'Suc'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

    }
}

