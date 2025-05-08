<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('12345678');

        $usuarios = [
            ['name' => 'admin', 'email' => 'admin@gmail.com', 'role' => 'Administrador'],
            ['name' => 'gerente', 'email' => 'gerente@gmail.com', 'role' => 'Gerente'],
            ['name' => 'cliente', 'email' => 'cliente@gmail.com', 'role' => 'Cliente'],
            ['name' => 'recepcionista', 'email' => 'recepcionista@gmail.com', 'role' => 'Recepcionista'],
            ['name' => 'especialista', 'email' => 'especialista@gmail.com', 'role' => 'Especialista'],
        ];

        foreach ($usuarios as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'email_verified_at' => now(),
                    'password' => $password,
                    'activo' => 1,
                ]
            );
            $user->assignRole($data['role']);
        }
    }
}
