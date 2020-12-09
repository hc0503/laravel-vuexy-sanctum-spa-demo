<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PermissionResource;

class MeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $arrPermissions = [];
        foreach ($this->roles->first()->permissions as $rolePermission) {
            array_push($arrPermissions, $rolePermission->name);
        }
        $permissions = array_unique(array_merge($this->permissions->pluck('name')->toArray(), $arrPermissions));
        
        return [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->roles->pluck('name')->first(),
            'permissions' => $permissions,
        ];
    }
}
