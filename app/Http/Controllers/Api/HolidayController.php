<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use App\Models\Holiday;

class HolidayController extends Controller  implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Holiday')
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'statistics' => [
                'count' => Holiday::count(),
            ],
            'holidays' => Holiday::all(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'min:3', 'max:50', 'string', 'unique:holidays,name'],
            'start' => ['required', 'string', 'min:3', 'max:10'],
            'end' => ['required', 'string', 'min:3', 'max:10'],
        ]);

        if (!$validator->fails()) {
            try {
                Holiday::create($validator->validated());
                return response()->json([
                    'message' => 'This Holiday was successfully established'
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
            $holiday = Holiday::where('id', $id)->firstOrFail();
            return response()->json([
                'holiday' => $holiday
            ], 202);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Sorry, We Don\' see this Holiday',
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
            $holiday = Holiday::where('id', $id)->firstOrFail();

            $validator = Validator::make($request->all(), [
                'title' => ['required', 'min:3', 'max:50', 'string', 'unique:holidays,name,' . $id],
                'start' => ['required', 'string', 'min:3', 'max:10'],
                'end' => ['required', 'string', 'min:3', 'max:10'],
            ]);

            if (!$validator->fails()) {
                try {
                    $holiday->update($validator->validated());
                    return response()->json([
                        'message' => 'This Holiday has been updated successfully..'
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
                'message' => 'Sorry, We Don\' Found this Holiday',
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
            Holiday::find($id)->delete();

            return response()->json([
                'message' => 'This Holiday has been successfully delete'
            ], 202);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'something is wrong!',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
