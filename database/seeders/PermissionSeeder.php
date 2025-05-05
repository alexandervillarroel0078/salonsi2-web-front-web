<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);

        // Roles
        Permission::create(['name' => 'ver roles']);
        Permission::create(['name' => 'crear roles']);
        Permission::create(['name' => 'editar roles']);
        Permission::create(['name' => 'eliminar roles']);

        // Empleados
        Permission::create(['name' => 'ver empleados']);
        Permission::create(['name' => 'crear empleados']);
        Permission::create(['name' => 'editar empleados']);
        Permission::create(['name' => 'eliminar empleados']);

        // Clientes
        Permission::create(['name' => 'ver clientes']);
        Permission::create(['name' => 'crear clientes']);
        Permission::create(['name' => 'editar clientes']);
        Permission::create(['name' => 'eliminar clientes']);

        // Servicios
        Permission::create(['name' => 'ver servicios']);
        Permission::create(['name' => 'crear servicios']);
        Permission::create(['name' => 'editar servicios']);
        Permission::create(['name' => 'eliminar servicios']);

        // Promociones
        Permission::create(['name' => 'ver promociones']);
        Permission::create(['name' => 'crear promociones']);
        Permission::create(['name' => 'editar promociones']);
        Permission::create(['name' => 'eliminar promociones']);

        // Citas
        Permission::create(['name' => 'ver citas']);
        Permission::create(['name' => 'crear citas']);
        Permission::create(['name' => 'editar citas']);
        Permission::create(['name' => 'eliminar citas']);

        // Especialistas / Personal
        Permission::create(['name' => 'ver especialistas']);
        Permission::create(['name' => 'ver su agenda']);
        Permission::create(['name' => 'marcar asistencia']);

        // Gestión
        Permission::create(['name' => 'gestionar citas']);
        Permission::create(['name' => 'gestionar clientes']);
        Permission::create(['name' => 'ver reportes']);
        Permission::create(['name' => 'calificar servicios']);

        // Bitácora
      //  Permission::create(['name' => 'ver bitácora']);
        // Backup
      
        // Asistencias
  
        // Cargos (si usas categorías de servicios)
        Permission::create(['name' => 'ver cargos']);

  
      
        // Combos
        Permission::create(['name' => 'ver combos']);
        Permission::create(['name' => 'crear combos']);
        Permission::create(['name' => 'editar combos']);
        Permission::create(['name' => 'eliminar combos']);

        // Horarios
        Permission::create(['name' => 'ver horarios']);
        Permission::create(['name' => 'crear horarios']);
        Permission::create(['name' => 'editar horarios']);
        Permission::create(['name' => 'eliminar horarios']);

        // Backups
        Permission::create(['name' => 'ver backups']);
        Permission::create(['name' => 'crear backups']);
        Permission::create(['name' => 'descargar backups']);
        Permission::create(['name' => 'restaurar backups']);
        Permission::create(['name' => 'eliminar backups']);

        // Asistencias
        Permission::create(['name' => 'ver asistencias']);
        Permission::create(['name' => 'crear asistencias']);
        Permission::create(['name' => 'editar asistencias']);
        Permission::create(['name' => 'eliminar asistencias']);
    }
}
