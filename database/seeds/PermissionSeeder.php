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
        ]);
        Permission::create([
            'name' => 'createuser',
        ]);
        Permission::create([
            'name' => 'updateuser',
        ]);
        Permission::create([
            'name' => 'deleteuser',
        ]);
    }
}
