
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use App\Models\Attendace;
use App\Models\User;

class AttendaceController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:attendace')
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'attendace_today' => Attendace::where('created_at', now()->today())->count(),
            'attendaces' => Attendace::where('created_at', now()->today())->get(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_id' => ['required', 'integer', 'unique:users,id'],
            'worker_id' => ['required', 'integer', 'exists:users,id'],
            'presence' => ['nullable', 'datetime'],
            'departure' => ['nullable', 'datetime']
        ]);

        if (!$validator->fails()) {
            try {
                Attendace::create($validator->validated());

                // Check From Time presence, departure
                $worker = User::firstOrFail('id', 1);
                if ($worker->roles->first()->start_work < now()->time()) {
                    // خصم الان باشمهندسه جاي من بيته متاخر
                }
                if (!empty($request->input('departure')) && $worker->roles->first()->end_work < now()->time()) {
                    // خصم, لانه مشي بدري, البيه
                }

                return response()->json([
                    'message' => 'This Attendace was successfully established'
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
            $attendace = Attendace::where('id', $id)->firstOrFail();
            return response()->json([
                'Attendace' => $attendace
            ], 202);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Sorry, We Don\' see this Attendace',
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
            $attendace = Attendace::where('id', $id)->firstOrFail();

            $validator = Validator::make($request->all(), [
                'admin_id' => ['required', 'integer', 'unique:users,id'],
                'worker_id' => ['required', 'integer', 'exists:users,id'],
                'presence' => ['nullable', 'datetime'],
                'departure' => ['nullable', 'datetime']
            ]);

            if (!$validator->fails()) {
                try {
                    $attendace->update($validator->validated());
                    return response()->json([
                        'message' => 'This Attendace has been updated successfully..'
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
                'message' => 'Sorry, We Don\' Found this Attendace',
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
            Attendace::find($id)->delete();

            return response()->json([
                'message' => 'This Attendace has been successfully delete'
            ], 202);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'something is wrong!',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
