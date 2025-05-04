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

        // Usuario ADMINISTRADOR
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'activo' => 1,
            'email_verified_at' => now(),
            'password' => $password,
        ]);
        $admin->assignRole('Administrador');

        // Usuario GERENTE
        $gerente = User::create([
            'name' => 'gerente',
            'email' => 'gerente@gmail.com',
            'activo' => 1,
            'email_verified_at' => now(),
            'password' => $password,
        ]);
        $gerente->assignRole('Gerente');

        // Usuario CLIENTE
        $cliente = User::create([
            'name' => 'cliente',
            'email' => 'cliente@gmail.com',
            'activo' => 1,
            'email_verified_at' => now(),
            'password' => $password,
        ]);
        $cliente->assignRole('Cliente');

        // Usuario RECEPCIONISTA
        $recepcion = User::create([
            'name' => 'recepcionista',
            'email' => 'recepcionista@gmail.com',
            'activo' => 1,
            'email_verified_at' => now(),
            'password' => $password,
        ]);
        $recepcion->assignRole('Recepcionista');

        // Usuario ESPECIALISTA
        $especialista = User::create([
            'name' => 'especialista',
            'email' => 'especialista@gmail.com',
            'activo' => 1,
            'email_verified_at' => now(),
            'password' => $password,
        ]);
        $especialista->assignRole('Especialista');
    }
}
