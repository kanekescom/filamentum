<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleUserTest extends TestCase
{
    use RefreshDatabase;

    protected function seedRolesAndUsers()
    {
        $this->seed(RoleUserSeeder::class);
    }

    /** @test */
    public function super_admin_user_has_super_admin_role()
    {
        $this->seedRolesAndUsers();

        $user = User::where('email', 'superadmin@filamentum.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('Super Admin'));
        $this->assertFalse($user->hasRole('Admin'));
        $this->assertFalse($user->hasRole('User'));
    }

    /** @test */
    public function admin_user_has_admin_role()
    {
        $this->seedRolesAndUsers();

        $user = User::where('email', 'admin@filamentum.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('Admin'));
        $this->assertFalse($user->hasRole('Super Admin'));
        $this->assertFalse($user->hasRole('User'));
    }

    /** @test */
    public function regular_user_has_user_role()
    {
        $this->seedRolesAndUsers();

        $user = User::where('email', 'user@filamentum.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('User'));
        $this->assertFalse($user->hasRole('Super Admin'));
        $this->assertFalse($user->hasRole('Admin'));
    }

    /** @test */
    public function roles_are_created_correctly()
    {
        $this->seedRolesAndUsers();

        $this->assertDatabaseHas('roles', ['name' => 'Super Admin']);
        $this->assertDatabaseHas('roles', ['name' => 'Admin']);
        $this->assertDatabaseHas('roles', ['name' => 'User']);

        $this->assertEquals(3, Role::count());
    }
}
