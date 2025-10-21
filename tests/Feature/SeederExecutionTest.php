<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

it('can execute all seeders through artisan command', function () {
    // Execute the db:seed command
    $this->artisan('db:seed')
        ->assertExitCode(0);

    // Assert that roles are created
    expect(Role::where('name', 'Super Admin')->exists())->toBeTrue();
    expect(Role::where('name', 'Admin')->exists())->toBeTrue();
    expect(Role::where('name', 'User')->exists())->toBeTrue();

    // Assert that permissions are created
    expect(Permission::where('name', 'ViewAny:User')->exists())->toBeTrue();
    expect(Permission::where('name', 'Create:User')->exists())->toBeTrue();

    // Assert that users are created
    expect(User::where('email', 'superadmin@filamentum.com')->exists())->toBeTrue();
    expect(User::where('email', 'admin@filamentum.com')->exists())->toBeTrue();
    expect(User::where('email', 'user@filamentum.com')->exists())->toBeTrue();
});

it('can execute individual seeders', function () {
    // Execute ShieldSeeder
    $this->artisan('db:seed', ['--class' => 'ShieldSeeder'])
        ->expectsOutputToContain('Shield Seeding Completed.')
        ->assertExitCode(0);

    // Assert that roles and permissions are created
    expect(Role::count())->toBe(3);
    expect(Permission::count())->toBe(22);

    // Execute RoleUserSeeder
    $this->artisan('db:seed', ['--class' => 'RoleUserSeeder'])
        ->assertExitCode(0);

    // Assert that users are created
    expect(User::count())->toBe(3);
});
