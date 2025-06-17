<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            ['name' => 'Camila Rojas', 'email' => 'camila1@gmail.com', 'phone' => '789456123', 'photo_url' => 'https://images.pexels.com/photos/5384371/pexels-photo-5384371.jpeg'],
            ['name' => 'Lucía Fernández', 'email' => 'lucia2@gmail.com', 'phone' => '789456124', 'photo_url' => 'https://images.pexels.com/photos/4065301/pexels-photo-4065301.jpeg'],
            ['name' => 'Valeria Gutiérrez', 'email' => 'valeria3@gmail.com', 'phone' => '789456125', 'photo_url' => 'https://www.pexels.com/es-es/foto/foto-en-primer-plano-de-mujer-con-abrigo-marron-y-top-gris-733872/'],
            ['name' => 'Sofía Martínez', 'email' => 'sofia4@gmail.com', 'phone' => '789456126', 'photo_url' => 'https://images.pexels.com/photos/5322200/pexels-photo-5322200.jpeg'],
            ['name' => 'Natalia Herrera', 'email' => 'natalia5@gmail.com', 'phone' => '789456127', 'photo_url' => 'https://images.pexels.com/photos/3065192/pexels-photo-3065192.jpeg'],
            ['name' => 'Mónica Castro', 'email' => 'monica6@gmail.com', 'phone' => '789456128', 'photo_url' => 'https://images.pexels.com/photos/5977112/pexels-photo-5977112.jpeg'],
            ['name' => 'Fernanda Ruiz', 'email' => 'fernanda7@gmail.com', 'phone' => '789456129', 'photo_url' => 'https://images.pexels.com/photos/3660636/pexels-photo-3660636.jpeg'],
            ['name' => 'Mariana Salazar', 'email' => 'mariana8@gmail.com', 'phone' => '789456130', 'photo_url' => 'https://images.pexels.com/photos/5384373/pexels-photo-5384373.jpeg'],
            ['name' => 'Isabela Romero', 'email' => 'isabela9@gmail.com', 'phone' => '789456131', 'photo_url' => 'https://images.pexels.com/photos/3568545/pexels-photo-3568545.jpeg'],
            ['name' => 'Daniela Cabrera', 'email' => 'daniela10@gmail.com', 'phone' => '789456132', 'photo_url' => 'https://images.pexels.com/photos/3772507/pexels-photo-3772507.jpeg'],
        ];

        foreach ($clientes as $cliente) {
            Cliente::firstOrCreate(
                ['email' => $cliente['email']],
                [
                    'name' => $cliente['name'],
                    'phone' => $cliente['phone'],
                    'photo_url' => $cliente['photo_url'],
                    'status' => true,
                ]
            );
        }
    }
}
