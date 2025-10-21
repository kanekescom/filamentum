<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = [
            [
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'permissions' => [
                    'ViewAny:User',
                    'View:User',
                    'Create:User',
                    'Update:User',
                    'Delete:User',
                    'Restore:User',
                    'ForceDelete:User',
                    'ForceDeleteAny:User',
                    'RestoreAny:User',
                    'Replicate:User',
                    'Reorder:User',
                    'ViewAny:Role',
                    'View:Role',
                    'Create:Role',
                    'Update:Role',
                    'Delete:Role',
                    'Restore:Role',
                    'ForceDelete:Role',
                    'ForceDeleteAny:Role',
                    'RestoreAny:Role',
                    'Replicate:Role',
                    'Reorder:Role',
                ],
            ],
            [
                'name' => 'Admin',
                'guard_name' => 'web',
                'permissions' => [
                    'ViewAny:User',
                    'View:User',
                    'Create:User',
                    'Update:User',
                    'Delete:User',
                    'Restore:User',
                    'ForceDelete:User',
                    'ForceDeleteAny:User',
                    'RestoreAny:User',
                    'Replicate:User',
                    'Reorder:User',
                ],
            ],
            [
                'name' => 'User',
                'guard_name' => 'web',
                'permissions' => [],
            ],
        ];

        $directPermissions = [];

        $this->makeRolesWithPermissions(json_encode($rolesWithPermissions));
        $this->makeDirectPermissions(json_encode($directPermissions));

        // Only output info if running in console
        if ($this->command) {
            $this->command->info('Shield Seeding Completed.');
        }
    }

    protected function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = Role::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => Permission::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            foreach ($permissions as $permission) {
                if (Permission::whereName($permission)->doesntExist()) {
                    Permission::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
