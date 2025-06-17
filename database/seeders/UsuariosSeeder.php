<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Personal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('12345678');

        // Crear roles si no existen
        $roles = ['Administrador', 'Gerente', 'Cliente', 'Recepcionista', 'Especialista'];
        foreach ($roles as $rol) {
            Role::firstOrCreate(['name' => $rol, 'guard_name' => 'web']);
        }

        // Obtener clientes y especialistas ya creados
        $clientes = Cliente::take(3)->get()->values(); // asegura índices [0], [1], [2]
        $especialistas = Personal::take(5)->get()->values(); // asegura índices [0]...[4]

        // Verificación de existencia mínima
        if ($clientes->count() < 3 || $especialistas->count() < 5) {
            throw new \Exception("Se necesitan al menos 3 clientes y 5 especialistas antes de ejecutar UsuariosSeeder.");
        }

        // Lista de usuarios
        $usuarios = [
            ['name' => 'admin',          'email' => 'admin@gmail.com',         'role' => 'Administrador'],
            ['name' => 'gerente',        'email' => 'gerente@gmail.com',       'role' => 'Gerente'],
            ['name' => 'recepcionista',  'email' => 'recepcionista@gmail.com', 'role' => 'Recepcionista', 'personal' => $especialistas[0]],
            ['name' => 'cliente1',       'email' => 'cliente1@gmail.com',      'role' => 'Cliente',       'cliente'  => $clientes[0]],
            ['name' => 'cliente2',       'email' => 'cliente2@gmail.com',      'role' => 'Cliente',       'cliente'  => $clientes[1]],
            ['name' => 'especialist1',   'email' => 'especialist1@gmail.com',  'role' => 'Especialista',  'personal' => $especialistas[0]],
            ['name' => 'especialist2',   'email' => 'especialist2@gmail.com',  'role' => 'Especialista',  'personal' => $especialistas[1]],
            ['name' => 'especialist3',   'email' => 'especialist3@gmail.com',  'role' => 'Especialista',  'personal' => $especialistas[2]],
            ['name' => 'especialist4',   'email' => 'especialist4@gmail.com',  'role' => 'Especialista',  'personal' => $especialistas[3]],
            ['name' => 'especialist5',   'email' => 'especialist5@gmail.com',  'role' => 'Especialista',  'personal' => $especialistas[4]],
        ];

        // Crear usuarios y asignar roles
        foreach ($usuarios as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => $password,
                    'email_verified_at' => now(),
                    'activo' => true,
                    'cliente_id' => $data['cliente']->id ?? null,
                    'personal_id' => $data['personal']->id ?? null,
                ]
            );

            if (!$user->hasRole($data['role'])) {
                $user->assignRole($data['role']);
            }
        }
    }
}
