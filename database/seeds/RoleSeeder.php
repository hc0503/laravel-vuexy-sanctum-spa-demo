<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->truncate();
        Role::create([
            'name' => 'SuperAdmin',
            'guard_name' => 'web'
        ])
        ->givePermissionTo([
            'viewuser',
            'createuser',
            'edituser',
            'deleteuser',
            'viewrole',
            'createrole',
            'editrole',
            'deleterole'
        ]);
    }
}
