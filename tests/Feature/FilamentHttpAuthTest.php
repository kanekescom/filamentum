<?php

use App\Models\User;
use Database\Seeders\RoleUserSeeder;
use Database\Seeders\ShieldSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(ShieldSeeder::class);
    $this->seed(RoleUserSeeder::class);

    // Get the super admin user created by the seeders
    $this->superAdmin = User::where('email', 'superadmin@filamentum.com')->first();
});

it('can display login page', function () {
    $response = $this->get('/admin/login');

    $response->assertStatus(200);
});

it('can login with valid credentials using actingAs', function () {
    // Test that we can authenticate a user
    $this->actingAs($this->superAdmin);

    $response = $this->get('/admin');
    $response->assertStatus(200);
});

it('cannot access admin panel when not authenticated', function () {
    $response = $this->get('/admin');

    $response->assertRedirect('/admin/login');
});

it('can logout when authenticated', function () {
    // First login
    $this->actingAs($this->superAdmin);

    // Access admin panel to confirm authentication
    $response = $this->get('/admin');
    $response->assertStatus(200);

    // Test logout
    $response = $this->post('/admin/logout');
    $response->assertStatus(302);
    $this->assertGuest();
});
