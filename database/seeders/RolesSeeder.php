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
        $almacenero = Role::firstOrCreate(['name' => 'Almacenero', 'guard_name' => 'web']);

        // Asignar todos los permisos al administrador
        $admin->syncPermissions([
            // Usuarios y roles
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',
            'ver roles',
            'crear roles',
            'editar roles',
            'eliminar roles',

            // Empleados / personal
            'ver empleados',
            'crear empleados',
            'editar empleados',
            'eliminar empleados',

            // Servicios
            'ver servicios',
            'crear servicios',
            'editar servicios',
            'eliminar servicios',

            // Promociones
            'ver promociones',
            'crear promociones',
            'editar promociones',
            'eliminar promociones',

            // Combos
            'ver combos',
            'crear combos',
            'editar combos',
            'eliminar combos',

            // Citas
            'ver citas',
            'crear citas',
            'editar citas',
            'eliminar citas',

            // Horarios
            'ver horarios',
            'crear horarios',
            'editar horarios',
            'eliminar horarios',

            // Reportes y bitácora
            'ver reportes',
            'ver bitácora',

            // Backups (solo lectura/creación/descarga, sin restaurar ni eliminar)
            'ver backups',
            'crear backups',
            'descargar backups',


                        // Asistencias
            'ver asistencias',
            'crear asistencias',
            'editar asistencias',
            'eliminar asistencias',
        ]);
        // Permisos para clientes
        $cliente->syncPermissions([
            'ver servicios',
            'calificar servicios',
            'ver promociones',
            'crear citas',
            'ver citas',
            'Citas del cliente',
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
            'Citas del personal',
            'Servicios del personal',
        ]);

        // Permisos para gerente
        $gerente->syncPermissions([
            'ver reportes',
            'ver citas',
            'ver bitácora',
        ]);
        // Almacenero
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
