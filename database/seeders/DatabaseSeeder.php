<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            RoleSeeder::class,
            RolesAndPermissionsSeeder::class,
            AdminUserSeeder::class,
            AuditorUserSeeder::class,
        ]);

        // The admin user creation logic is now handled by AdminUserSeeder.php
        // No need to create it here again.
    }
}
