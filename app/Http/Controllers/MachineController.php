<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Factory;
use App\Models\MachineFactory;
use App\Models\MachineRawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // If Role == Admin
        $machines = Machine::all();
        return response()->json([
            'message' => 'Suc',
            'data'    => $machines
        ]);

        /* -------If Role == Factory Manager------- */
        // $factory = Factory::where('manager_id', Auth::user()->id)->first();
        // $machines = $factory->machines;
        // return response()->json([
        //     'message' => 'Suc',
        //     'data'    => $machines
        // ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //If Role == Admin
        $validate = Validator::make($request->all(), [
            'name'       => ['string', 'required', 'min:3', 'max:255'],
            'price'      => ['integer', 'required'],
            'is_damage'  => ['required', 'boolean'],
            'quantity'   => ['integer', 'required'],
            'factory_id' => ['integer', 'required'],
            'machine_id' => ['integer', 'required']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $machine = Machine::create([
            'name'      => $request->name,
            'price'     => $request->price,
            'is_damage' => $request->is_damage
        ]);

        foreach($request->factories as $factory) {

            MachineFactory::create([
                'machine_id' => $machine->id,
                'factory_id' => $factory,
                'quantity'   => $request->quantity[$factory]
            ]);

        }

        foreach($request->raw_materials as $raw_material) {

            MachineRawMaterial::create([
                'machine_id' => $machine->id,
                'raw_material_id' => $raw_material
            ]);

        }

        return response()->json([
            'message' => 'Suc'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $machine       = Machine::findOrFail($id);
        $products      = $machine->products;
        $raw_materials = $machine->raw_materials;
        $factories     = $machine->factories;
        return response()->json([
            'Message'       => 'Suc',
            'machine'       => $machine,
            'products'      => $products,
            'raw_materials' => $raw_materials,
            'factories'     => $factories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        // If Role == Admin
        $validate = Validator::make($request->all(), [
            'name'       => ['string', 'required', 'min:3', 'max:255'],
            'price'      => ['integer', 'required'],
            'is_damage'  => ['required', 'boolean'],
            'quantity'   => ['integer', 'required'],
            'factory_id' => ['integer', 'required'],
            'machine_id' => ['integer', 'required']
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 400);
        }

        $machine_factories = MachinFactory::where('machine_id', $id)->get();
        foreach($machine_factories as $machine_factory) {
            $machine_factory->destroy($machine_factory->id);
        }

        Machine::findOrFail($id)->update([
            'name'      => $request->name,
            'price'     => $request->price,
            'is_damage' => $request->is_damage
        ]);
        
        foreach($request->factories as $factory) {

            MachineFactory::create([
                'machine_id' => $machine->id,
                'factory_id' => $factory,
                'quantity'   => $request->quantity[$factory]
            ]);

        }

        foreach($request->raw_materials as $raw_material) {

            MachineRawMaterial::create([
                'machine_id' => $machine->id,
                'raw_material_id' => $raw_material
            ]);
            
        }

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