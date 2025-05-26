<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles sin duplicar
        $admin = Role::firstOrCreate(['name' => 'Administrador', 'guard_name' => 'web']);
        $cliente = Role::firstOrCreate(['name' => 'Cliente', 'guard_name' => 'web']);
        $recepcionista = Role::firstOrCreate(['name' => 'Recepcionista', 'guard_name' => 'web']);
        $especialista = Role::firstOrCreate(['name' => 'Especialista', 'guard_name' => 'web']);
        $gerente = Role::firstOrCreate(['name' => 'Gerente', 'guard_name' => 'web']);

        // Asignar todos los permisos al administrador
        $admin->syncPermissions(Permission::all());

        // Permisos para clientes
        $cliente->syncPermissions([
            'ver servicios',
            'calificar servicios',
            'ver promociones',
            'crear citas',
            'ver citas',
        ]);

        // Permisos para recepcionista
        $recepcionista->syncPermissions([
            'gestionar clientes',
            'gestionar citas',
            'ver servicios',
            'ver promociones',
            'ver especialistas',
        ]);

        // Permisos para especialistas
        $especialista->syncPermissions([
            'ver su agenda',
            'marcar asistencia',
        ]);

        // Permisos para gerente
        $gerente->syncPermissions([
            'ver reportes',
            'ver citas',
            'ver bitácora',
        ]);
        // Almacenero
        $almacenero = Role::firstOrCreate(['name' => 'Almacenero', 'guard_name' => 'web']);
        $almacenero->syncPermissions([
            'ver inventario',
            'crear inventario',
            'editar inventario',
            'eliminar inventario',
            'ver movimientos inventario',
            'registrar movimientos inventario',
            
        ]);
        
    }
}
