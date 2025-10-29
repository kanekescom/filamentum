<?php

use App\Models\User;
use Database\Seeders\RoleUserSeeder;
use Database\Seeders\ShieldSeeder;

beforeEach(function () {
    $this->seed(ShieldSeeder::class);
    $this->seed(RoleUserSeeder::class);

    // Get all users created by the seeders
    $this->superAdmin = User::where('email', 'superadmin@filamentum.com')->first();
    $this->admin = User::where('email', 'admin@filamentum.com')->first();
    $this->regularUser = User::where('email', 'user@filamentum.com')->first();
});

// Dashboard Access Tests
it('allows super admin to access dashboard', function () {
    $this->actingAs($this->superAdmin);

    $response = $this->get(route('filament.app.pages.dashboard'));
    $response->assertStatus(200);
    $response->assertSee('Dashboard');
});

it('allows admin to access dashboard', function () {
    $this->actingAs($this->admin);

    $response = $this->get(route('filament.app.pages.dashboard'));
    $response->assertStatus(200);
    $response->assertSee('Dashboard');
});

it('allows regular user to access dashboard', function () {
    $this->actingAs($this->regularUser);

    $response = $this->get(route('filament.app.pages.dashboard'));
    $response->assertStatus(200);
    $response->assertSee('Dashboard');
});

// Dashboard Content Tests
it('displays correct dashboard content for super admin', function () {
    $this->actingAs($this->superAdmin);

    $response = $this->get(route('filament.app.pages.dashboard'));
    $response->assertStatus(200);

    // Check for common dashboard elements
    $response->assertSee('Dashboard');
    $response->assertSee($this->superAdmin->name);
});

it('displays correct dashboard content for admin', function () {
    $this->actingAs($this->admin);

    $response = $this->get(route('filament.app.pages.dashboard'));
    $response->assertStatus(200);

    // Check for common dashboard elements
    $response->assertSee('Dashboard');
    $response->assertSee($this->admin->name);
});

it('displays correct dashboard content for regular user', function () {
    $this->actingAs($this->regularUser);

    $response = $this->get(route('filament.app.pages.dashboard'));
    $response->assertStatus(200);

    // Check for common dashboard elements
    $response->assertSee('Dashboard');
    $response->assertSee($this->regularUser->name);
});

// Dashboard Security Tests
it('redirects unauthenticated users to login page', function () {
    $response = $this->get(route('filament.app.pages.dashboard'));

    $response->assertStatus(302);
    $response->assertRedirect(route('filament.app.auth.login'));
});

// Dashboard Navigation Tests
it('displays navigation menu for super admin', function () {
    $this->actingAs($this->superAdmin);

    $response = $this->get(route('filament.app.pages.dashboard'));
    $response->assertStatus(200);

    // Check for navigation elements
    $response->assertSee('nav');
    $response->assertSee('Users');
    $response->assertSee('Roles');
});

it('displays navigation menu for admin', function () {
    $this->actingAs($this->admin);

    $response = $this->get(route('filament.app.pages.dashboard'));
    $response->assertStatus(200);

    // Check for navigation elements
    $response->assertSee('nav');
    $response->assertSee('Users');
    // Admin should not see Roles menu
    $response->assertDontSee('Roles');
});

it('displays limited navigation menu for regular user', function () {
    $this->actingAs($this->regularUser);

    $response = $this->get(route('filament.app.pages.dashboard'));
    $response->assertStatus(200);

    // Check for navigation elements
    $response->assertSee('nav');
    // Regular user should have limited navigation
    $response->assertDontSee('Users');
    $response->assertDontSee('Roles');
});

// Dashboard Session Tests
it('maintains session when accessing dashboard', function () {
    // Authenticate as super admin
    $this->actingAs($this->superAdmin);

    // Access dashboard multiple times
    $response = $this->get(route('filament.app.pages.dashboard'));
    $response->assertStatus(200);
    $response->assertSee($this->superAdmin->name);

    $response = $this->get(route('filament.app.pages.dashboard'));
    $response->assertStatus(200);
    $response->assertSee($this->superAdmin->name);
});
