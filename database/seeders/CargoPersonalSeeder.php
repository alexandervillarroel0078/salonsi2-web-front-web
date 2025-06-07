<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CargoPersonal;  

class CargoPersonalSeeder extends Seeder
{
    public function run(): void
    {
        $cargos = [
            'Estilista',
            'Barbero',
            'Manicurista',
            'Maquillador',
            'Gerente',
            'Recepcionista',
            'Barredor',
        ];

        foreach ($cargos as $cargo) {
            CargoPersonal::create([
                'cargo' => $cargo,
                'estado' => true,
            ]);
        }
    }
}
