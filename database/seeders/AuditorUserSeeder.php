<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AuditorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Auditor User
        $auditor = User::updateOrCreate(
            ['email' => 'auditor@contasys.com'],
            [
                'name' => 'Auditor ContaSys',
                'password' => Hash::make('password'),
            ]
        );

        // Assign Auditor role to the user
        $auditorRole = Role::where('name', 'Auditor')->first();
        if ($auditorRole) {
            $auditor->assignRole($auditorRole);
        }
    }
}
