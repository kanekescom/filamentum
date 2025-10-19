<?php

namespace Tests\Unit\Seeders;

use App\Models\User;
use Database\Seeders\RoleUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleUserSeederTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_three_roles()
    {
        $this->seed(RoleUserSeeder::class);

        $this->assertDatabaseHas('roles', ['name' => 'Super Admin']);
        $this->assertDatabaseHas('roles', ['name' => 'Admin']);
        $this->assertDatabaseHas('roles', ['name' => 'User']);

        $this->assertEquals(3, Role::count());
    }

    /** @test */
    public function it_creates_three_users_with_appropriate_roles()
    {
        $this->seed(RoleUserSeeder::class);

        // Check users exist
        $this->assertDatabaseHas('users', ['email' => 'superadmin@filamentum.com']);
        $this->assertDatabaseHas('users', ['email' => 'admin@filamentum.com']);
        $this->assertDatabaseHas('users', ['email' => 'user@filamentum.com']);

        // Check users have correct roles
        $superAdmin = User::where('email', 'superadmin@filamentum.com')->first();
        $admin = User::where('email', 'admin@filamentum.com')->first();
        $regularUser = User::where('email', 'user@filamentum.com')->first();

        $this->assertTrue($superAdmin->hasRole('Super Admin'));
        $this->assertTrue($admin->hasRole('Admin'));
        $this->assertTrue($regularUser->hasRole('User'));

        $this->assertEquals(3, User::count());
    }

    /** @test */
    public function it_does_not_duplicate_roles_on_multiple_runs()
    {
        // Run seeder twice
        $this->seed(RoleUserSeeder::class);
        $this->seed(RoleUserSeeder::class);

        // Should still only have 3 roles
        $this->assertEquals(3, Role::count());
    }
}
