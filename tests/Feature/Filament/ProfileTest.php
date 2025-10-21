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

// Profile Access Tests
it('allows super admin to access their profile', function () {
    $this->actingAs($this->superAdmin);

    $response = $this->get('/admin/profile');
    $response->assertStatus(200);
});

it('allows admin to access their profile', function () {
    $this->actingAs($this->admin);

    $response = $this->get('/admin/profile');
    $response->assertStatus(200);
});

it('allows regular user to access their profile', function () {
    $this->actingAs($this->regularUser);

    $response = $this->get('/admin/profile');
    $response->assertStatus(200);
});

// Profile Content Tests
it('displays correct user information on super admin profile', function () {
    $this->actingAs($this->superAdmin);

    $response = $this->get('/admin/profile');
    $response->assertStatus(200);

    // Verify the profile page shows the correct user's information
    $response->assertSee($this->superAdmin->name);
    $response->assertSee($this->superAdmin->email);
});

it('displays correct user information on admin profile', function () {
    $this->actingAs($this->admin);

    $response = $this->get('/admin/profile');
    $response->assertStatus(200);

    // Verify the profile page shows the correct user's information
    $response->assertSee($this->admin->name);
    $response->assertSee($this->admin->email);
});

it('displays correct user information on regular user profile', function () {
    $this->actingAs($this->regularUser);

    $response = $this->get('/admin/profile');
    $response->assertStatus(200);

    // Verify the profile page shows the correct user's information
    $response->assertSee($this->regularUser->name);
    $response->assertSee($this->regularUser->email);
});

// Profile Security Tests
it('ensures users can only access their own profile', function () {
    // Test that when each user accesses the profile route,
    // they see their own information, not someone else's
    $this->actingAs($this->regularUser);

    $response = $this->get('/admin/profile');
    $response->assertStatus(200);

    // Verify the profile page shows the correct user's information
    $response->assertSee($this->regularUser->name);
    $response->assertSee($this->regularUser->email);
    $response->assertDontSee($this->admin->name);
    $response->assertDontSee($this->superAdmin->name);
});
