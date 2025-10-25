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

// User View Tests
it('allows super admin to view user details', function () {
    $this->actingAs($this->superAdmin);

    // Test access to a specific user's page
    $response = $this->get("/admin/users/{$this->admin->id}");
    $response->assertStatus(200);

    // Check that the page contains user information
    $response->assertSee($this->admin->name);
    $response->assertSee($this->admin->email);
});

it('allows admin to view user details', function () {
    $this->actingAs($this->admin);

    // Test access to a specific user's page
    $response = $this->get("/admin/users/{$this->regularUser->id}");
    $response->assertStatus(200);

    // Check that the page contains user information
    $response->assertSee($this->regularUser->name);
    $response->assertSee($this->regularUser->email);
});

it('denies regular user from viewing other user details', function () {
    $this->actingAs($this->regularUser);

    // Test that regular user cannot view another user's page
    $response = $this->get("/admin/users/{$this->admin->id}");
    $response->assertStatus(403); // Forbidden
});

// User Edit Tests
it('allows super admin to access user edit page', function () {
    $this->actingAs($this->superAdmin);

    // Test access to a specific user's edit page
    $response = $this->get("/admin/users/{$this->admin->id}/edit");
    $response->assertStatus(200);

    // Check that the page contains user information
    $response->assertSee($this->admin->name);
    $response->assertSee($this->admin->email);
});

it('allows admin to access user edit page', function () {
    $this->actingAs($this->admin);

    // Test access to a specific user's edit page
    $response = $this->get("/admin/users/{$this->regularUser->id}/edit");
    $response->assertStatus(200);

    // Check that the page contains user information
    $response->assertSee($this->regularUser->name);
    $response->assertSee($this->regularUser->email);
});

it('denies regular user access to user edit page', function () {
    $this->actingAs($this->regularUser);

    // Test that regular user cannot access edit page
    $response = $this->get("/admin/users/{$this->admin->id}/edit");
    $response->assertStatus(403); // Forbidden
});

// User List Content Tests
it('displays correct user data on super admin user list', function () {
    $this->actingAs($this->superAdmin);

    $response = $this->get('/admin/users');
    $response->assertStatus(200);

    // Check that the page contains all users
    $response->assertSee($this->superAdmin->name);
    $response->assertSee($this->admin->name);
    $response->assertSee($this->regularUser->name);
});

it('displays correct user data on admin user list', function () {
    $this->actingAs($this->admin);

    $response = $this->get('/admin/users');
    $response->assertStatus(200);

    // Check that the page contains all users
    $response->assertSee($this->superAdmin->name);
    $response->assertSee($this->admin->name);
    $response->assertSee($this->regularUser->name);
});

it('denies regular user access to user list', function () {
    $this->actingAs($this->regularUser);

    $response = $this->get('/admin/users');
    $response->assertStatus(403); // Forbidden
});

// User Creation Form Tests
it('displays user creation form for super admin', function () {
    $this->actingAs($this->superAdmin);

    $response = $this->get('/admin/users/create');
    $response->assertStatus(200);

    // Check that the form contains expected fields
    $response->assertSee('name');
    $response->assertSee('email');
    $response->assertSee('password');
    $response->assertSee('input');
    $response->assertSee('button');
});

it('displays user creation form for admin', function () {
    $this->actingAs($this->admin);

    $response = $this->get('/admin/users/create');
    $response->assertStatus(200);

    // Check that the form contains expected fields
    $response->assertSee('name');
    $response->assertSee('email');
    $response->assertSee('password');
    $response->assertSee('input');
    $response->assertSee('button');
});

it('denies regular user access to user creation form', function () {
    $this->actingAs($this->regularUser);

    $response = $this->get('/admin/users/create');
    $response->assertStatus(403); // Forbidden
});

// User Edit Form Tests
it('displays user edit form for super admin', function () {
    $this->actingAs($this->superAdmin);

    $response = $this->get("/admin/users/{$this->admin->id}/edit");
    $response->assertStatus(200);

    // Check that the form contains expected fields
    $response->assertSee('name');
    $response->assertSee('email');
    $response->assertSee($this->admin->name);
    $response->assertSee($this->admin->email);
});

it('displays user edit form for admin', function () {
    $this->actingAs($this->admin);

    $response = $this->get("/admin/users/{$this->regularUser->id}/edit");
    $response->assertStatus(200);

    // Check that the form contains expected fields
    $response->assertSee('name');
    $response->assertSee('email');
    $response->assertSee($this->regularUser->name);
    $response->assertSee($this->regularUser->email);
});

it('denies regular user access to user edit form', function () {
    $this->actingAs($this->regularUser);

    $response = $this->get("/admin/users/{$this->admin->id}/edit");
    $response->assertStatus(403); // Forbidden
});
