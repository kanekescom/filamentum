<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run the Shield seeder first to set up roles and permissions
        $this->call(ShieldSeeder::class);

        // Run the role and user seeder
        $this->call(RoleUserSeeder::class);
    }
}
