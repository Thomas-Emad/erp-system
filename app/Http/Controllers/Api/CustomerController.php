<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class CustomerController extends Controller  implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:customer')
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'statistics' => [
                'count' => Customer::count(),
            ],
            'customers' => Customer::all(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_id' => ['required', 'integer', 'exists:users,id'],
            'name' => ['required', 'min:3', 'max:50', 'string', 'unique:customers,name'],
            'info' => ['nullable', 'string'],
        ]);

        if (!$validator->fails()) {
            try {
                Customer::create([
                    'admin_id' => $request->admin_id,
                    'name' => $request->name,
                    'info' => $request->info,
                ]);
                return response()->json([
                    'message' => 'This Customer was successfully established',
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => "Something is wrong!!",
                    'error' => $e->getMessage()
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
            $customer = Customer::where('id', $id)->firstOrFail();
            return response()->json([
                'customer' => $customer
            ], 202);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Sorry, We Don\' see this customer',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $customer = Customer::where('id', $id)->firstOrFail();

            $validator = Validator::make($request->all(), [
                'admin_id' => ['required', 'integer', 'exists:users,id'],
                'name' => ['required', 'min:3', 'max:50', 'string', 'unique:customers,name,' . $id],
                'info' => ['nullable', 'string'],
            ]);

            if (!$validator->fails()) {
                try {
                    $customer->update([
                        'admin_id' => $request->admin_id,
                        'name' => $request->name,
                        'info' => $request->info,
                    ]);
                    return response()->json([
                        'message' => 'This Customer has been updated successfully..'
                    ], 202);
                } catch (\Exception $e) {
                    return response()->json([
                        'message' => "Something is wrong!!",
                        'error' => $e->getMessage()
                    ], 500);
                }
            } else {
                return response()->json([
                    "errors" => $validator->errors()
                ], 400);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Sorry, We Don\' Found this customer',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Customer::find($id)->delete();

            return response()->json([
                'message' => 'This customer has been successfully delete'
            ], 202);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'something is wrong!',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
