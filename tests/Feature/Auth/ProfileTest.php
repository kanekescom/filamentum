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

it('redirects unauthenticated users to login when accessing profile', function () {
    $response = $this->get('/admin/profile');

    $response->assertStatus(302);
    $response->assertRedirect('/admin/login');
});

it('displays profile page with correct content for super admin', function () {
    // Authenticate as super admin
    $user = $this->superAdmin;
    $response = $this->actingAs($user)->get('/admin/profile');

    $response->assertStatus(200);
    $response->assertSee('Profile');
    $response->assertSee($user->name);
    $response->assertSee($user->email);
});

it('displays profile page with correct content for admin', function () {
    // Authenticate as admin
    $user = $this->admin;
    $response = $this->actingAs($user)->get('/admin/profile');

    $response->assertStatus(200);
    $response->assertSee('Profile');
    $response->assertSee($user->name);
    $response->assertSee($user->email);
});

it('displays profile page with correct content for regular user', function () {
    // Authenticate as regular user
    $user = $this->regularUser;
    $response = $this->actingAs($user)->get('/admin/profile');

    $response->assertStatus(200);
    $response->assertSee('Profile');
    $response->assertSee($user->name);
    $response->assertSee($user->email);
});

it('shows profile form with proper structure for super admin', function () {
    // Authenticate as super admin
    $user = $this->superAdmin;
    $response = $this->actingAs($user)->get('/admin/profile');

    $response->assertStatus(200);
    // Check for form elements
    $response->assertSee('input');
    $response->assertSee('button');
    $response->assertSee('name');
    $response->assertSee('email');
});

it('shows profile form with proper structure for admin', function () {
    // Authenticate as super admin
    $user = $this->admin;
    $response = $this->actingAs($user)->get('/admin/profile');

    $response->assertStatus(200);
    // Check for form elements
    $response->assertSee('input');
    $response->assertSee('button');
    $response->assertSee('name');
    $response->assertSee('email');
});

it('shows profile form with proper structure for regular user', function () {
    // Authenticate as super admin
    $user = $this->regularUser;
    $response = $this->actingAs($user)->get('/admin/profile');

    $response->assertStatus(200);
    // Check for form elements
    $response->assertSee('input');
    $response->assertSee('button');
    $response->assertSee('name');
    $response->assertSee('email');
});

it('prevents users from accessing other users profiles', function () {
    // Authenticate as regular user
    $user = $this->regularUser;
    $response = $this->actingAs($user)->get('/admin/profile');

    $response->assertStatus(200);
    $response->assertSee($user->name);
    $response->assertSee($user->email);
    // Should not see other users' names
    $response->assertDontSee($this->superAdmin->name);
    $response->assertDontSee($this->admin->name);
});

it('maintains proper session when accessing profile', function () {
    // Authenticate as admin
    $user = $this->admin;

    // Access profile multiple times
    $response = $this->actingAs($user)->get('/admin/profile');
    $response->assertStatus(200);
    $response->assertSee($user->name);

    $response = $this->get('/admin/profile');
    $response->assertStatus(200);
    $response->assertSee($user->name);
});

it('redirects to login after logout when accessing profile', function () {
    // Authenticate as super admin
    $user = $this->superAdmin;
    $this->actingAs($user);

    // Access profile
    $response = $this->get('/admin/profile');
    $response->assertStatus(200);

    // Logout
    $response = $this->post('/admin/logout');
    $response->assertStatus(302);
    $this->assertGuest();

    // Try to access profile again
    $response = $this->get('/admin/profile');
    $response->assertStatus(302);
    $response->assertRedirect('/admin/login');
});

it('allows super admin to access profile after authentication', function () {
    // Test super admin
    $response = $this->actingAs($this->superAdmin)->get('/admin/profile');
    $response->assertStatus(200);
    $response->assertSee($this->superAdmin->name);
    $response->assertSee($this->superAdmin->email);
});

it('allows admin to access profile after authentication', function () {
    // Test admin
    $response = $this->actingAs($this->admin)->get('/admin/profile');
    $response->assertStatus(200);
    $response->assertSee($this->admin->name);
    $response->assertSee($this->admin->email);
});

it('allows regular user to access profile after authentication', function () {
    // Test regular user
    $response = $this->actingAs($this->regularUser)->get('/admin/profile');
    $response->assertStatus(200);
    $response->assertSee($this->regularUser->name);
    $response->assertSee($this->regularUser->email);
});

it('prevents profile access after logout', function () {
    // Authenticate
    $this->actingAs($this->superAdmin);

    // Access profile
    $response = $this->get('/admin/profile');
    $response->assertStatus(200);

    // Logout
    $this->post('/admin/logout');

    // Try to access profile again
    $response = $this->get('/admin/profile');
    $response->assertRedirect('/admin/login');
});
