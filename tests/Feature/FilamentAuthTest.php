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

it('can display login page', function () {
    $response = $this->get('/admin/login');

    $response->assertStatus(200);
});

it('can login with valid credentials using actingAs for super admin', function () {
    // Test that we can authenticate a super admin user
    $this->actingAs($this->superAdmin);

    $response = $this->get('/admin');
    $response->assertStatus(200);
});

it('can login with valid credentials using actingAs for admin', function () {
    // Test that we can authenticate an admin user
    $this->actingAs($this->admin);

    $response = $this->get('/admin');
    $response->assertStatus(200);
});

it('can login with valid credentials using actingAs for regular user', function () {
    // Test that we can authenticate a regular user
    $this->actingAs($this->regularUser);

    $response = $this->get('/admin');
    $response->assertStatus(200);
});

it('cannot access admin panel when not authenticated', function () {
    $response = $this->get('/admin');

    $response->assertRedirect('/admin/login');
});

it('can logout when authenticated as super admin', function () {
    // First login as super admin
    $this->actingAs($this->superAdmin);

    // Access admin panel to confirm authentication
    $response = $this->get('/admin');
    $response->assertStatus(200);

    // Test logout
    $response = $this->post('/admin/logout');
    $response->assertStatus(302);
    $this->assertGuest();
});

it('can logout when authenticated as admin', function () {
    // First login as admin
    $this->actingAs($this->admin);

    // Access admin panel to confirm authentication
    $response = $this->get('/admin');
    $response->assertStatus(200);

    // Test logout
    $response = $this->post('/admin/logout');
    $response->assertStatus(302);
    $this->assertGuest();
});

it('can logout when authenticated as regular user', function () {
    // First login as regular user
    $this->actingAs($this->regularUser);

    // Access admin panel to confirm authentication
    $response = $this->get('/admin');
    $response->assertStatus(200);

    // Test logout
    $response = $this->post('/admin/logout');
    $response->assertStatus(302);
    $this->assertGuest();
});
