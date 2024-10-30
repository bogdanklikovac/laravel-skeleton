<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        Role::updateOrCreate(['name' => User::ROLE_USER, 'guard_name' => 'api']);
        Role::updateOrCreate(['name' => User::ROLE_ADMIN, 'guard_name' => 'api']);

        $adminUser = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'password' => Hash::make('admin'),
            ]
        );
        $adminUser->assignRole(User::ROLE_ADMIN);

        $regularUser = User::updateOrCreate(
            ['email' => 'user@user.com'],
            [
                'first_name' => 'User',
                'last_name' => 'Q',
                'password' => Hash::make('user'),
            ]
        );
        $regularUser->assignRole(User::ROLE_USER);
    }
}
