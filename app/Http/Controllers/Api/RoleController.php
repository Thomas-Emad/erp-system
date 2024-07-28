<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PremissionResponse;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:role'),
        ];
    }


    public function index()
    {
        $roles = Role::orderBy('id', 'ASC')->paginate(5);
        return response()->json([
            'roles' => $roles
        ]);
    }

    public function getAllPremission()
    {
        $permission = Permission::get();
        return response()->json([
            'permissions' =>  PremissionResponse::collection($permission)
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array',
            'start_work' => 'required|date_format:H:i',
            'end_work' => 'required|date_format:H:i',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try {
            $role = Role::create([
                'name' =>  $request->input('name'),
                'start_work' => $request->input('start_work'),
                'end_work' => $request->input('end_work'),
            ]);

            $permissionIds = $request->input('permission');
            $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();

            if (empty($permissionNames)) {
                return response()->json([
                    'message' => 'No valid permissions found for the provided IDs.'
                ], 422);
            }

            $role->syncPermissions($permissionNames);

            return response()->json([
                'message' => 'Role Has Been Created Successfully'
            ]);
        } catch (\Exception  $e) {
            return response()->json([
                'message' => 'Something is wrong!!',
                'error' => $e->getMessage() // Return the exception message for debugging
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $role = Role::findOrFail($id);
            $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
                ->where("role_has_permissions.role_id", $id)
                ->get();

            return response()->json([
                'role' => $role,
                'premissions' => PremissionResponse::collection($rolePermissions)
            ]);
        } catch (\Exception  $e) {
            return response()->json([
                'message' => 'Something is wrong!!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id,
            'permission' => 'required|array',
            'start_work' => 'required|date_format:H:i',
            'end_work' => 'required|date_format:H:i',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        try {
            $role = Role::findOrFail($id);
            $role->name = $request->input('name');
            $role->start_work = $request->input('start_work');
            $role->end_work = $request->input('end_work');
            $role->save();

            // Check from Permissions Then Put Names in Array
            $permissionIds = $request->input('permission');
            $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();

            if (empty($permissionNames)) {
                return response()->json([
                    'message' => 'No valid permissions found for the provided IDs.'
                ], 422);
            }
            $role->syncPermissions($permissionNames);

            return response()->json([
                'message' => 'Role Has Been Updated Successfully'
            ]);
        } catch (\Exception  $e) {
            return response()->json([
                'message' => 'Something is wrong!!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Role::firstOrFail('id', $id)->delete();
            return response()->json([
                'message' => 'delete Role is done',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something is wrong!!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
