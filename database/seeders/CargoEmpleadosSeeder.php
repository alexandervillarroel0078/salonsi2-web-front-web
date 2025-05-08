<?php

namespace Database\Seeders;

use App\Models\CargoEmpleado;
use Illuminate\Database\Seeder;

class CargoEmpleadosSeeder extends Seeder
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
            CargoEmpleado::create([
                'cargo' => $cargo,
                'estado' => true,
            ]);
        }
    }
}
