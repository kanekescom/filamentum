<?php

use Database\Seeders\ShieldSeeder;
use Database\Seeders\RoleUserSeeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(ShieldSeeder::class);
    $this->seed(RoleUserSeeder::class);
});

it('creates roles and users with correct assignments', function () {
    // Assert that users are created
    $this->assertDatabaseHas('users', ['email' => 'superadmin@filamentum.com']);
    $this->assertDatabaseHas('users', ['email' => 'admin@filamentum.com']);
    $this->assertDatabaseHas('users', ['email' => 'user@filamentum.com']);

    // Assert that the Super Admin user has the correct role
    $superAdminUser = User::where('email', 'superadmin@filamentum.com')->first();
    expect($superAdminUser->hasRole('Super Admin'))->toBeTrue();
    expect($superAdminUser->hasRole('Admin'))->toBeFalse();
    expect($superAdminUser->hasRole('User'))->toBeFalse();

    // Assert that the Admin user has the correct role
    $adminUser = User::where('email', 'admin@filamentum.com')->first();
    expect($adminUser->hasRole('Admin'))->toBeTrue();
    expect($adminUser->hasRole('Super Admin'))->toBeFalse();
    expect($adminUser->hasRole('User'))->toBeFalse();

    // Assert that the Regular User has the correct role
    $regularUser = User::where('email', 'user@filamentum.com')->first();
    expect($regularUser->hasRole('User'))->toBeTrue();
    expect($regularUser->hasRole('Super Admin'))->toBeFalse();
    expect($regularUser->hasRole('Admin'))->toBeFalse();
});

it('does not duplicate users or roles', function () {
    // Run the seeders again
    $this->seed(ShieldSeeder::class);
    $this->seed(RoleUserSeeder::class);

    // Assert that users are not duplicated
    expect(User::count())->toBe(3);

    // Assert that roles are not duplicated
    expect(Role::count())->toBe(3);
});

it('assigns default password to users', function () {
    // Check that users have the default password (hashed)
    $superAdminUser = User::where('email', 'superadmin@filamentum.com')->first();
    expect(Hash::check('password', $superAdminUser->password))->toBeTrue();

    $adminUser = User::where('email', 'admin@filamentum.com')->first();
    expect(Hash::check('password', $adminUser->password))->toBeTrue();

    $regularUser = User::where('email', 'user@filamentum.com')->first();
    expect(Hash::check('password', $regularUser->password))->toBeTrue();
});
