<?php

use App\Models\User;
use Database\Seeders\RoleUserSeeder;
use Database\Seeders\ShieldSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->seed(ShieldSeeder::class);
    $this->seed(RoleUserSeeder::class);

    // Get all users created by the seeders
    $this->superAdmin = User::where('email', 'superadmin@filamentum.com')->first();
    $this->admin = User::where('email', 'admin@filamentum.com')->first();
    $this->regularUser = User::where('email', 'user@filamentum.com')->first();

    // Get roles
    $this->superAdminRole = Role::findByName('Super Admin');
    $this->adminRole = Role::findByName('Admin');
    $this->userRole = Role::findByName('User');
});

// Role Resource Access Tests
it('allows super admin to access role resource pages', function () {
    $this->actingAs($this->superAdmin);

    // Test access to role list page
    $response = $this->get('/admin/shield/roles');
    $response->assertStatus(200);

    // Test access to role creation page
    $response = $this->get('/admin/shield/roles/create');
    $response->assertStatus(200);
});

it('denies admin access to role resource pages', function () {
    $this->actingAs($this->admin);

    // Test that admin cannot access role list
    $response = $this->get('/admin/shield/roles');
    $response->assertStatus(403); // Forbidden

    // Test that admin cannot access role creation
    $response = $this->get('/admin/shield/roles/create');
    $response->assertStatus(403); // Forbidden
});

it('denies regular user access to role resource pages', function () {
    $this->actingAs($this->regularUser);

    // Test that regular user cannot access role list
    $response = $this->get('/admin/shield/roles');
    $response->assertStatus(403); // Forbidden

    // Test that regular user cannot access role creation
    $response = $this->get('/admin/shield/roles/create');
    $response->assertStatus(403); // Forbidden
});

// Role View Tests
it('allows super admin to view role details', function () {
    $this->actingAs($this->superAdmin);

    // Test access to a specific role's page
    $response = $this->get("/admin/shield/roles/{$this->superAdminRole->id}");
    $response->assertStatus(200);

    // Check that the page contains role information
    $response->assertSee($this->superAdminRole->name);
});

it('denies admin from viewing role details', function () {
    $this->actingAs($this->admin);

    // Test that admin cannot view role page
    $response = $this->get("/admin/shield/roles/{$this->superAdminRole->id}");
    $response->assertStatus(403); // Forbidden
});

it('denies regular user from viewing role details', function () {
    $this->actingAs($this->regularUser);

    // Test that regular user cannot view role page
    $response = $this->get("/admin/shield/roles/{$this->superAdminRole->id}");
    $response->assertStatus(403); // Forbidden
});

// Role Edit Tests
it('allows super admin to access role edit page', function () {
    $this->actingAs($this->superAdmin);

    // Test access to a specific role's edit page
    $response = $this->get("/admin/shield/roles/{$this->adminRole->id}/edit");
    $response->assertStatus(200);

    // Check that the page contains role information
    $response->assertSee($this->adminRole->name);
});

it('denies admin access to role edit page', function () {
    $this->actingAs($this->admin);

    // Test that admin cannot access edit page
    $response = $this->get("/admin/shield/roles/{$this->superAdminRole->id}/edit");
    $response->assertStatus(403); // Forbidden
});

it('denies regular user access to role edit page', function () {
    $this->actingAs($this->regularUser);

    // Test that regular user cannot access edit page
    $response = $this->get("/admin/shield/roles/{$this->superAdminRole->id}/edit");
    $response->assertStatus(403); // Forbidden
});

// Role List Content Tests
it('displays correct role data on super admin role list', function () {
    $this->actingAs($this->superAdmin);

    $response = $this->get('/admin/shield/roles');
    $response->assertStatus(200);

    // Check that the page contains role names
    $response->assertSee('Super Admin');
    $response->assertSee('Admin');
    $response->assertSee('User');
});

it('denies admin access to role list', function () {
    $this->actingAs($this->admin);

    $response = $this->get('/admin/shield/roles');
    $response->assertStatus(403); // Forbidden
});

it('denies regular user access to role list', function () {
    $this->actingAs($this->regularUser);

    $response = $this->get('/admin/shield/roles');
    $response->assertStatus(403); // Forbidden
});

// Role Creation Form Tests
it('displays role creation form for super admin', function () {
    $this->actingAs($this->superAdmin);

    $response = $this->get('/admin/shield/roles/create');
    $response->assertStatus(200);

    // Check that the form contains expected fields
    $response->assertSee('name');
    $response->assertSee('guard_name');
    $response->assertSee('input');
    $response->assertSee('button');
});

it('denies admin access to role creation form', function () {
    $this->actingAs($this->admin);

    $response = $this->get('/admin/shield/roles/create');
    $response->assertStatus(403); // Forbidden
});

it('denies regular user access to role creation form', function () {
    $this->actingAs($this->regularUser);

    $response = $this->get('/admin/shield/roles/create');
    $response->assertStatus(403); // Forbidden
});

// Role Edit Form Tests
it('displays role edit form for super admin', function () {
    $this->actingAs($this->superAdmin);

    $response = $this->get("/admin/shield/roles/{$this->userRole->id}/edit");
    $response->assertStatus(200);

    // Check that the form contains expected fields
    $response->assertSee('name');
    $response->assertSee('guard_name');
    $response->assertSee($this->userRole->name);
});

it('denies admin access to role edit form', function () {
    $this->actingAs($this->admin);

    $response = $this->get("/admin/shield/roles/{$this->userRole->id}/edit");
    $response->assertStatus(403); // Forbidden
});

it('denies regular user access to role edit form', function () {
    $this->actingAs($this->regularUser);

    $response = $this->get("/admin/shield/roles/{$this->userRole->id}/edit");
    $response->assertStatus(403); // Forbidden
});
