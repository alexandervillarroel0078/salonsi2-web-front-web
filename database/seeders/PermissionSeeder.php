<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permisos = [
            // Usuarios
            'ver usuarios',
            'crear usuarios',
            'editar usuarios',
            'eliminar usuarios',

            // Roles
            'ver roles',
            'crear roles',
            'editar roles',
            'eliminar roles',

            // Empleados
            'ver empleados',
            'crear empleados',
            'editar empleados',
            'eliminar empleados',
            'Citas del personal',
            'Servicios del personal',

            // Clientes
            'ver clientes',
            'crear clientes',
            'editar clientes',
            'eliminar clientes',
            'Citas del cliente',

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

            // Citas
            'ver citas',
            'crear citas',
            'editar citas',
            'eliminar citas',

            // Especialistas / Personal
            'ver especialistas',
            'ver su agenda',
            'marcar asistencia',

            // Gestión
            'gestionar citas',
            'gestionar clientes',
            'ver reportes',
            'calificar servicios',

            // Bitácora
            'ver bitácora',

            // Cargos
            'ver cargos',
            'crear cargos',
            'editar cargos',
            'eliminar cargos',
            // Combos
            'ver combos',
            'crear combos',
            'editar combos',
            'eliminar combos',

            // Horarios
            'ver horarios',
            'crear horarios',
            'editar horarios',
            'eliminar horarios',

            // Backups
            'ver backups',
            'crear backups',
            'descargar backups',
            'restaurar backups',
            'eliminar backups',

            // Asistencias
            'ver asistencias',
            'crear asistencias',
            'editar asistencias',
            'eliminar asistencias',
            // Inventario
            'ver inventario',
            'crear inventario',
            'editar inventario',
            'eliminar inventario',
            'ver movimientos inventario',
            'registrar movimientos inventario',
            'registrar movimientos',
            //productos
            'ver productos',
            'crear productos',
            'editar productos',
            'eliminar productos',
            'exportar productos',

            // Sucursales
            'ver sucursales',
            'crear sucursales',
            'editar sucursales',
            'eliminar sucursales',

            // Sugerencias
            'ver sugerencias',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => 'web'
            ]);
        }
    }
}
