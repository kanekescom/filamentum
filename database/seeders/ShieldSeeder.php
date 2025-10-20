<?php

namespace Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;
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
                'name' => 'User',
                'guard_name' => 'web',
                'permissions' => [],
            ],
        ];

        $directPermissions = [];

        static::makeRolesWithPermissions(json_encode($rolesWithPermissions));
        static::makeDirectPermissions(json_encode($directPermissions));

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
