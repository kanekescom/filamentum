<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        // Create users with roles
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@filamentum.com'],
            [
                'name' => 'Super Admin User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assign role only if user doesn't already have it
        if (!$superAdmin->hasRole('Super Admin')) {
            $superAdmin->assignRole($superAdminRole);
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@filamentum.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assign role only if user doesn't already have it
        if (!$admin->hasRole('Admin')) {
            $admin->assignRole($adminRole);
        }

        $regularUser = User::firstOrCreate(
            ['email' => 'user@filamentum.com'],
            [
                'name' => 'Regular User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assign role only if user doesn't already have it
        if (!$regularUser->hasRole('User')) {
            $regularUser->assignRole($userRole);
        }
    }
}
