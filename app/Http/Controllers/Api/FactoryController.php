<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use App\Models\Factory;

class FactoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:factory')
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'statistics' => [
                'count' => Factory::count(),
            ],
            'factories' => Factory::all(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:3', 'max:50', 'string', 'unique:factories,name']
        ]);

        if ($validator->valid()) {
            try {
                Factory::create([
                    'name' => $request->name
                ]);
                return response()->json([
                    'message' => 'This factory was successfully established'
                ], 201);
            } catch (ErrorException $e) {
                return response()->json([
                    'message' => "Something is wrong!!"
                ], 500);
            }
        } else {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $factory = Factory::where('id', $id)->firstOrFail();
            return response()->json([
                'factory' => $factory
            ], 202);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Sorry, We Don\' see this Factory'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $factory = Factory::where('id', $id)->firstOrFail();

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'min:3', 'max:50', 'string', 'unique:factories,name,' . $id]
            ]);

            if ($validator->valid()) {
                try {
                    $factory->update([
                        'name' => $request->name
                    ]);
                    return response()->json([
                        'message' => 'This Factory has been updated successfully..'
                    ], 202);
                } catch (ErrorException $e) {
                    return response()->json([
                        'message' => "Something is wrong!!"
                    ], 500);
                }
            } else {
                return response()->json([
                    "errors" => $validator->errors()
                ], 400);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Sorry, We Don\' Found this Factory'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Factory::find($id)->delete();

            return response()->json([
                'message' => 'This factory has been successfully delete'
            ], 202);
        } catch (ErrorException $e) {
            return response()->json([
                'message' => 'something is wrong!'
            ], 404);
        }
    }
}
