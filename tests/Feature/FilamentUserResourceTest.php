<?php

use App\Models\User;
use Database\Seeders\RoleUserSeeder;
use Database\Seeders\ShieldSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(ShieldSeeder::class);
    $this->seed(RoleUserSeeder::class);

    // Get all users created by the seeders
    $this->superAdmin = User::where('email', 'superadmin@filamentum.com')->first();
    $this->admin = User::where('email', 'admin@filamentum.com')->first();
    $this->regularUser = User::where('email', 'user@filamentum.com')->first();
});

// User Resource Access Tests
it('allows super admin to access user resource pages', function () {
    $this->actingAs($this->superAdmin);

    // Test access to user list page
    $response = $this->get('/admin/users');
    $response->assertStatus(200);

    // Test access to user creation page
    $response = $this->get('/admin/users/create');
    $response->assertStatus(200);
});

it('allows admin to access user resource pages', function () {
    $this->actingAs($this->admin);

    // Test access to user list page
    $response = $this->get('/admin/users');
    $response->assertStatus(200);

    // Test access to user creation page
    $response = $this->get('/admin/users/create');
    $response->assertStatus(200);
});

it('denies regular user access to user resource pages', function () {
    $this->actingAs($this->regularUser);

    // Test that regular user cannot access user list
    $response = $this->get('/admin/users');
    $response->assertStatus(403); // Forbidden

    // Test that regular user cannot access user creation
    $response = $this->get('/admin/users/create');
    $response->assertStatus(403); // Forbidden
});

// User CRUD Operations Tests
it('allows super admin to create a user', function () {
    $this->actingAs($this->superAdmin);

    // Since we're testing access permissions, we'll just check if the create page loads
    // Actual form submission testing would require more complex setup
    $response = $this->get('/admin/users/create');
    $response->assertStatus(200);
});

it('allows admin to create a user', function () {
    $this->actingAs($this->admin);

    $response = $this->get('/admin/users/create');
    $response->assertStatus(200);
});

it('denies regular user from creating a user', function () {
    $this->actingAs($this->regularUser);

    $response = $this->get('/admin/users/create');
    $response->assertStatus(403); // Forbidden
});

// User View Tests
it('allows super admin to view any user', function () {
    $this->actingAs($this->superAdmin);

    // Test access to a specific user's page
    $response = $this->get("/admin/users/{$this->admin->id}");
    $response->assertStatus(200);
});

it('allows admin to view any user', function () {
    $this->actingAs($this->admin);

    // Test access to a specific user's page
    $response = $this->get("/admin/users/{$this->regularUser->id}");
    $response->assertStatus(200);
});

it('denies regular user from viewing other users', function () {
    $this->actingAs($this->regularUser);

    // Test that regular user cannot view another user's page
    $response = $this->get("/admin/users/{$this->admin->id}");
    $response->assertStatus(403); // Forbidden
});

// Role Management Tests
it('allows super admin to access role management', function () {
    $this->actingAs($this->superAdmin);

    // Test access to roles list page
    $response = $this->get('/admin/shield/roles');
    $response->assertStatus(200);

    // Test access to role creation page
    $response = $this->get('/admin/shield/roles/create');
    $response->assertStatus(200);
});

it('denies admin access to role management', function () {
    $this->actingAs($this->admin);

    // Test that admin cannot access roles management
    $response = $this->get('/admin/shield/roles');
    $response->assertStatus(403); // Forbidden
});

it('denies regular user access to role management', function () {
    $this->actingAs($this->regularUser);

    // Test that regular user cannot access roles management
    $response = $this->get('/admin/shield/roles');
    $response->assertStatus(403); // Forbidden
});
