<?php

use App\Models\User;
use Database\Seeders\RoleUserSeeder;
use Database\Seeders\ShieldSeeder;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->seed(ShieldSeeder::class);
    $this->seed(RoleUserSeeder::class);

    // Get users created by the seeders
    $this->superAdmin = User::where('email', 'superadmin@filamentum.com')->first();
    $this->admin = User::where('email', 'admin@filamentum.com')->first();
    $this->regularUser = User::where('email', 'user@filamentum.com')->first();

    // Get roles
    $this->superAdminRole = Role::findByName('Super Admin');
    $this->adminRole = Role::findByName('Admin');
    $this->userRole = Role::findByName('User');
});

// Test role permissions according to ShieldSeeder
it('verifies super admin has all user permissions', function () {
    $userPermissions = [
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
    ];

    foreach ($userPermissions as $permission) {
        expect($this->superAdminRole->hasPermissionTo($permission))->toBeTrue();
    }
});

it('verifies admin has limited user permissions', function () {
    $allowedPermissions = [
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
    ];

    $restrictedPermissions = [
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
    ];

    // Admin should have all user permissions
    foreach ($allowedPermissions as $permission) {
        expect($this->adminRole->hasPermissionTo($permission))->toBeTrue();
    }

    // Admin should not have role management permissions
    foreach ($restrictedPermissions as $permission) {
        expect($this->adminRole->hasPermissionTo($permission))->toBeFalse();
    }
});

it('verifies regular user has no permissions', function () {
    // Regular user should have no permissions assigned
    expect($this->userRole->permissions)->toHaveCount(0);
});

it('verifies user role assignments are correct', function () {
    expect($this->superAdmin->hasRole('Super Admin'))->toBeTrue();
    expect($this->admin->hasRole('Admin'))->toBeTrue();
    expect($this->regularUser->hasRole('User'))->toBeTrue();
});
