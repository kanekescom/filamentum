<?php

use Database\Seeders\ShieldSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(ShieldSeeder::class);
});

it('creates roles with permissions', function () {
    // Assert that roles are created
    $this->assertDatabaseHas('roles', ['name' => 'Super Admin']);
    $this->assertDatabaseHas('roles', ['name' => 'Admin']);
    $this->assertDatabaseHas('roles', ['name' => 'User']);

    // Assert that permissions are created
    $this->assertDatabaseHas('permissions', ['name' => 'ViewAny:User']);
    $this->assertDatabaseHas('permissions', ['name' => 'Create:User']);
    $this->assertDatabaseHas('permissions', ['name' => 'Update:User']);
    $this->assertDatabaseHas('permissions', ['name' => 'Delete:User']);

    // Assert that Super Admin has all permissions
    $superAdminRole = Role::where('name', 'Super Admin')->first();
    expect($superAdminRole->hasPermissionTo('ViewAny:User'))->toBeTrue();
    expect($superAdminRole->hasPermissionTo('Create:User'))->toBeTrue();
    expect($superAdminRole->hasPermissionTo('Update:User'))->toBeTrue();
    expect($superAdminRole->hasPermissionTo('Delete:User'))->toBeTrue();

    // Assert that Admin has all permissions
    $adminRole = Role::where('name', 'Admin')->first();
    expect($adminRole->hasPermissionTo('ViewAny:User'))->toBeTrue();
    expect($adminRole->hasPermissionTo('Create:User'))->toBeTrue();
    expect($adminRole->hasPermissionTo('Update:User'))->toBeTrue();
    expect($adminRole->hasPermissionTo('Delete:User'))->toBeTrue();

    // Assert that User has no permissions
    $userRole = Role::where('name', 'User')->first();
    expect($userRole->permissions()->count())->toBe(0);
});

it('does not duplicate roles or permissions', function () {
    // Run the seeder again
    $this->seed(ShieldSeeder::class);

    // Assert that roles are not duplicated
    expect(Role::count())->toBe(3);

    // Assert that permissions are not duplicated
    expect(Permission::count())->toBe(22);
});
