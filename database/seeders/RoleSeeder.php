<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Administrador'], ['guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Contador'], ['guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Auditor'], ['guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Usuario Básico'], ['guard_name' => 'web']);
    }
}
