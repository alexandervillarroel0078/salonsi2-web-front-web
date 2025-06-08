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
            'Maquillador/a',
            'Recepcionista',
            'Gerente del Salón',
            'Personal de Limpieza',
        ];

        foreach ($cargos as $cargo) {
            CargoPersonal::create([
                'cargo' => $cargo,
                'estado' => true,
            ]);
        }
    }
}
