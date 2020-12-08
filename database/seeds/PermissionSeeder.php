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
        $permissions = [
            ['name' => 'viewuser', 'guard_name' => 'web'],
            ['name' => 'createuser', 'guard_name' => 'web'],
            ['name' => 'edituser', 'guard_name' => 'web'],
            ['name' => 'deleteuser', 'guard_name' => 'web'],
            ['name' => 'viewrole', 'guard_name' => 'web'],
            ['name' => 'createrole', 'guard_name' => 'web'],
            ['name' => 'editrole', 'guard_name' => 'web'],
            ['name' => 'deleterole', 'guard_name' => 'web'],
        ];
        Permission::insert($permissions);
    }
}
