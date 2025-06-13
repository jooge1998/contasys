<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view_dashboard' => 'Can view dashboard',
            'manage_users' => 'Can manage users',
            'manage_roles' => 'Can manage roles',
            'manage_permissions' => 'Can manage permissions',
            'view_transactions' => 'Can view transactions',
            'create_transactions' => 'Can create transactions',
            'edit_transactions' => 'Can edit transactions',
            'delete_transactions' => 'Can delete transactions',
            'view_audit' => 'Can view audit logs',
            'view_inventory' => 'Can view inventory',
            'manage_inventory' => 'Can manage inventory',
        ];

        foreach ($permissions as $name => $description) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ], [
                'description' => $description
            ]);
        }

        // Create roles and assign permissions
        $roles = [
            'Administrador' => [
                'description' => 'Full system access',
                'permissions' => array_keys($permissions)
            ],
            'Contador' => [
                'description' => 'Can manage transactions and inventory',
                'permissions' => [
                    'view_dashboard',
                    'view_transactions',
                    'create_transactions',
                    'edit_transactions',
                    'delete_transactions',
                    'view_inventory',
                    'manage_inventory'
                ]
            ],
            'Auditor' => [
                'description' => 'Can view audit logs and transactions',
                'permissions' => [
                    'view_dashboard',
                    'view_transactions',
                    'view_audit',
                    'view_inventory'
                ]
            ],
            'Usuario' => [
                'description' => 'Basic user access',
                'permissions' => [
                    'view_dashboard',
                    'view_transactions',
                    'view_inventory'
                ]
            ]
        ];

        foreach ($roles as $name => $data) {
            $role = Role::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ], [
                'description' => $data['description']
            ]);

            $role->givePermissionTo($data['permissions']);
        }
    }
}
