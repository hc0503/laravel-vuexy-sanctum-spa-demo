<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::query()->truncate();
        Permission::create([
            'name' => 'viewuser',
            // 'guard_name' => 'sanctum'
        ]);
        Permission::create([
            'name' => 'createuser',
            // 'guard_name' => 'sanctum'
        ]);
        Permission::create([
            'name' => 'edituser',
            // 'guard_name' => 'sanctum'
        ]);
        Permission::create([
            'name' => 'deleteuser',
            // 'guard_name' => 'sanctum'
        ]);
    }
}
