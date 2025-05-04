<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        $admin = Role::create(['name' => 'Administrador']);
        $cliente = Role::create(['name' => 'Cliente']);
        $recepcionista = Role::create(['name' => 'Recepcionista']);
        $especialista = Role::create(['name' => 'Especialista']);
        $gerente = Role::create(['name' => 'Gerente']);

        // Asignar todos los permisos al administrador
        $admin->givePermissionTo(Permission::all());

        // Permisos para clientes (pueden ver y agendar sus propias citas)
        $cliente->givePermissionTo([
            'ver servicios',
            'calificar servicios',
            'ver promociones',
            'crear citas',
            'ver citas',
             
        ]);

        // Permisos para recepcionista
        $recepcionista->givePermissionTo([
            'gestionar clientes',
            'gestionar citas',
            'ver servicios',
            'ver promociones',
            'ver especialistas',
        ]);

        // Permisos para especialistas (solo pueden ver su agenda y marcar asistencia)
        $especialista->givePermissionTo([
            'ver su agenda',
            'marcar asistencia',
        ]);

        // Permisos para gerente (solo visualización y bitácora)
        $gerente->givePermissionTo([
            'ver reportes',
            'ver citas',
            'ver bitácora',
        ]);
    }
}
