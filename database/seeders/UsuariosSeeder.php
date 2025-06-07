<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('12345678');

        // Asegurar que los roles existen (opcional, si no se corrió RoleSeeder antes)
        $roles = [
            'Administrador',
            'Gerente',
            'Cliente',
            'Recepcionista',
            'Especialista',
        ];

        foreach ($roles as $rol) {
            Role::firstOrCreate(['name' => $rol, 'guard_name' => 'web']);
        }

        $usuarios = [
            ['name' => 'admin', 'email' => 'admin@gmail.com', 'role' => 'Administrador'],
            ['name' => 'gerente', 'email' => 'gerente@gmail.com', 'role' => 'Gerente'],
            ['name' => 'cliente', 'email' => 'cliente@gmail.com', 'role' => 'Cliente'],
            ['name' => 'recepcionista', 'email' => 'recepcionista@gmail.com', 'role' => 'Recepcionista'],
            ['name' => 'especialista', 'email' => 'especialista@gmail.com', 'role' => 'Especialista'],
            ['name' => 'Miss Cathrine Schultz Sr.', 'email' => 'rosalinda.price@gmail.com', 'role' => 'Cliente'],
        ];

        foreach ($usuarios as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'email_verified_at' => now(),
                    'password' => $password,
                    'activo' => true,
                ]
            );

            // Asignar rol solo si aún no lo tiene
            if (!$user->hasRole($data['role'])) {
                $user->assignRole($data['role']);
            }
        }
    }
}
