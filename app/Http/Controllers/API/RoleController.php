<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    /**
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request)
    {
        $roles = Role::all();

        return RoleResource::collection($roles);
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @param \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetail(Request $request, Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ])
        ->givePermissionTo($request->permissions);
        
        return new RoleResource($role);
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @param \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdate(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191'
        ]);

        $role->update([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        $permissions = $request->permissions ?? [];
        $role->syncPermissions($permissions);

        return new RoleResource($role);
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @param \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(Request $request, Role $role)
    {
        $result = $role->delete();
        
        return response()->json([
            'success' => $result
        ]);
    }
}
