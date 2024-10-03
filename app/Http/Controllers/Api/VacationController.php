
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use App\Models\Vacation;
use Illuminate\Validation\Rule;
use App\Enums\VacationDay;

class VacationController extends Controller  implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:vacation')
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'statistics' => [
                'count' => Vacation::count(),
            ],
            'vacations' => Vacation::all(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_id' => ['required', 'unique:users,id'],
            'user_id' => ['required', 'unique:users,id'],
            'vacation_day' => ['required', Rule::enum(VacationDay::class)],
        ]);

        if (!$validator->fails()) {
            try {
                Vacation::create($validator->validated());
                return response()->json([
                    'message' => 'This Vacation was successfully established'
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
            $vacation = Vacation::where('id', $id)->firstOrFail();
            return response()->json([
                'Vacation' => $vacation
            ], 202);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Sorry, We Don\' see this Vacation',
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
            $vacation = Vacation::where('id', $id)->firstOrFail();

            $validator = Validator::make($request->all(), [
                'admin_id' => ['required', 'unique:users,id'],
                'user_id' => ['required', 'unique:users,id'],
                'vacation_day' => ['required', Rule::enum(VacationDay::class)],
            ]);

            if (!$validator->fails()) {
                try {
                    $vacation->update($validator->validated());
                    return response()->json([
                        'message' => 'This Vacation has been updated successfully..'
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
                'message' => 'Sorry, We Don\' Found this Vacation',
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
            Vacation::find($id)->delete();

            return response()->json([
                'message' => 'This Vacation has been successfully delete'
            ], 202);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'something is wrong!',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
