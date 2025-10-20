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
        $this->createRoles();
        $this->createUsers();
    }

    /**
     * Create the required roles.
     */
    private function createRoles(): void
    {
        $roles = ['Super Admin', 'Admin', 'User'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }
    }

    /**
     * Create users with their respective roles.
     */
    private function createUsers(): void
    {
        $users = [
            [
                'name' => 'Super Admin User',
                'email' => 'superadmin@filamentum.com',
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@filamentum.com',
                'role' => 'Admin',
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@filamentum.com',
                'role' => 'User',
            ],
        ];

        foreach ($users as $userData) {
            $this->createUserWithRole($userData);
        }
    }

    /**
     * Create a user with the specified role.
     */
    private function createUserWithRole(array $userData): void
    {
        $user = User::firstOrCreate(
            ['email' => $userData['email']],
            [
                'name' => $userData['name'],
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assign role only if user doesn't already have it
        if (! $user->hasRole($userData['role'])) {
            $user->assignRole($userData['role']);
        }
    }
}
