<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Enums\VacationDay;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!User::where('email', $request->email)->first()->hasPermissionTo('login') || !$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Check From Role Editor
        if (!auth()->user()->hasPermissionTo('users')) {
            return response()->json([
                'message' => "Sorry, You do not have right Permission!!",
            ], 500);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'national_id' => 'required|string|min:6|unique:users',
            'phone' => 'required|string|min:3',
            'sallary' =>  'required|integer|min:1000|max:1000000',
            'wallet' =>  'nullable|integer',
            'bus_id' => 'required|integer',
            'today_price' =>  'required|integer|min:10|max:1000',
            'roles' => 'required',
            'vacation_day' => 'required', [Rule::enum(VacationDay::class)],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => Hash::make($request->password)]
        ));
        $user->assignRole($request->input('roles'));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateByAdmin(Request $request, $id)
    {
        // Check From Role Editor
        if (!auth()->user()->hasPermissionTo('users')) {
            return response()->json([
                'message' => "Sorry, You do not have right Permission!!",
            ], 500);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'national_id' => 'required|string|min:6|unique:users,national_id,' . $id,
            'phone' => 'required|string|min:3',
            'sallary' =>  'required|integer|min:1000|max:1000000',
            'wallet' =>  'required|string|min:3|max:256',
            'bus_id' => 'required|integer',
            'today_price' =>  'required|integer|min:10|max:1000',
            'roles' => 'required',
            'vacation_day' => 'required', [Rule::enum(VacationDay::class)],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Save Data
        try {
            $input = $request->all();
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }

            $user = User::find($id);
            $user->update($input);
            DB::table('model_has_roles')->where('model_id', $id)->delete();

            $user->assignRole($request->input('roles'));

            return response()->json([
                'message' => 'User successfully Updated',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Something is wrong!!",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
