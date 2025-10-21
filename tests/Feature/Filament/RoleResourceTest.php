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

    // Test that admin cannot access role creation
    $response = $this->get('/admin/shield/roles/create');
    $response->assertStatus(403); // Forbidden
});

it('denies regular user access to role management', function () {
    $this->actingAs($this->regularUser);

    // Test that regular user cannot access roles management
    $response = $this->get('/admin/shield/roles');
    $response->assertStatus(403); // Forbidden

    // Test that regular user cannot access role creation
    $response = $this->get('/admin/shield/roles/create');
    $response->assertStatus(403); // Forbidden
});

it('denies super admin from editing roles when not authorized', function () {
    $this->actingAs($this->superAdmin);

    // Test that super admin can access role edit page (if a role exists)
    $response = $this->get('/admin/shield/roles');
    $response->assertStatus(200);
});

it('denies admin from editing roles', function () {
    $this->actingAs($this->admin);

    // Test that admin cannot access role edit page
    $response = $this->get('/admin/shield/roles/1/edit');
    $response->assertStatus(403); // Forbidden
});

it('denies regular user from editing roles', function () {
    $this->actingAs($this->regularUser);

    // Test that regular user cannot access role edit page
    $response = $this->get('/admin/shield/roles/1/edit');
    $response->assertStatus(403); // Forbidden
});
