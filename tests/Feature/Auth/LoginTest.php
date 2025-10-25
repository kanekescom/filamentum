<?php

use App\Models\User;
use Database\Seeders\RoleUserSeeder;
use Database\Seeders\ShieldSeeder;

beforeEach(function () {
    $this->seed(ShieldSeeder::class);
    $this->seed(RoleUserSeeder::class);

    // Get test users
    $this->superAdmin = User::where('email', 'superadmin@filamentum.com')->first();
    $this->admin = User::where('email', 'admin@filamentum.com')->first();
    $this->regularUser = User::where('email', 'user@filamentum.com')->first();
});

it('displays the login page with correct content', function () {
    $response = $this->get('/admin/login');

    $response->assertStatus(200);
    $response->assertSee('Login');
    $response->assertSee('Email');
    $response->assertSee('Password');
    $response->assertSee('email');
    $response->assertSee('password');
    $response->assertSee('input');
    $response->assertSee('button');
});

it('displays login form with proper structure', function () {
    $response = $this->get('/admin/login');

    $response->assertStatus(200);
    // Check for form element
    $response->assertSee('<form', false);
    // Check for CSRF token field
    $response->assertSee('csrf', false);
    // Check for submit button
    $response->assertSee('submit', false);
});

it('redirects unauthenticated users to login page', function () {
    $response = $this->get('/admin');

    $response->assertStatus(302);
    $response->assertRedirect('/admin/login');
});

it('allows access to admin panel after authentication', function () {
    $user = $this->superAdmin;
    $response = $this->actingAs($user)->get('/admin');

    $response->assertStatus(200);
    $response->assertSee('Dashboard');
});

it('successfully logs out authenticated users', function () {
    $user = $this->superAdmin;
    $this->actingAs($user);

    // Verify user is authenticated
    $this->assertAuthenticatedAs($user);

    // Test logout
    $response = $this->post('/admin/logout');

    $response->assertStatus(302);
    $response->assertRedirect('/admin/login');
    $this->assertGuest();
});

it('redirects authenticated users away from login page', function () {
    $user = $this->superAdmin;
    $response = $this->actingAs($user)->get('/admin/login');

    $response->assertStatus(302);
    $response->assertRedirect('/admin');
});

it('maintains proper session state', function () {
    // Initially should be a guest
    $this->assertGuest();

    // Authenticate user
    $user = $this->superAdmin;
    $this->actingAs($user);

    // Should now be authenticated
    $this->assertAuthenticatedAs($user);

    // Logout
    $this->post('/admin/logout');

    // Should be a guest again
    $this->assertGuest();
});

it('prevents access to admin resources after logout', function () {
    $user = $this->superAdmin;

    // Authenticate
    $this->actingAs($user);
    $this->assertAuthenticated();

    // Access protected resource
    $response = $this->get('/admin');
    $response->assertStatus(200);

    // Logout
    $this->post('/admin/logout');
    $this->assertGuest();

    // Try to access protected resource again
    $response = $this->get('/admin');
    $response->assertStatus(302);
    $response->assertRedirect('/admin/login');
});
