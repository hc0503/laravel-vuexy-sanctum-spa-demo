<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->truncate();
        $user = factory(User::class)->create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
        ]);

        $user->assignRole('SuperAdmin');
    }
}
