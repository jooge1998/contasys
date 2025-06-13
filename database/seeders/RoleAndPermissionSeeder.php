<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos
        $permissions = [
            // Permisos de Usuario
            'ver-perfil',
            'editar-perfil',
            
            // Permisos de Transacciones
            'ver-transacciones',
            'crear-transacciones',
            'editar-transacciones',
            'eliminar-transacciones',
            
            // Permisos de Inventario
            'ver-inventario',
            'crear-inventario',
            'editar-inventario',
            'eliminar-inventario',
            
            // Permisos de Auditoría
            'ver-auditoria',
            'generar-reportes',
            
            // Permisos de Administración
            'gestionar-usuarios',
            'gestionar-roles',
            'gestionar-permisos',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles y asignar permisos
        $roles = [
            'Usuario Básico' => [
                'ver-perfil',
                'editar-perfil',
            ],
            'Contador' => [
                'ver-perfil',
                'editar-perfil',
                'ver-transacciones',
                'crear-transacciones',
                'editar-transacciones',
                'ver-inventario',
                'crear-inventario',
                'editar-inventario',
            ],
            'Auditor' => [
                'ver-perfil',
                'editar-perfil',
                'ver-auditoria',
                'generar-reportes',
            ],
            'Administrador' => [
                'ver-perfil',
                'editar-perfil',
                'ver-transacciones',
                'crear-transacciones',
                'editar-transacciones',
                'eliminar-transacciones',
                'ver-inventario',
                'crear-inventario',
                'editar-inventario',
                'eliminar-inventario',
                'ver-auditoria',
                'generar-reportes',
                'gestionar-usuarios',
                'gestionar-roles',
                'gestionar-permisos',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            // Buscar o crear el rol
            $role = Role::firstOrCreate(['name' => $roleName]);
            
            // Sincronizar permisos
            $role->syncPermissions($rolePermissions);
        }
    }
} 