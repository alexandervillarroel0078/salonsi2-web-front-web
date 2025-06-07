<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Personal;
use App\Models\Asistencia;

class AsistenciaSeeder extends Seeder
{
    public function run(): void
    {
        $personales = Personal::all();

        if ($personales->isEmpty()) {
            $this->command->warn('No hay personal para registrar asistencias.');
            return;
        }

        foreach ($personales as $personal) {
            for ($i = 1; $i <= 5; $i++) {
                Asistencia::create([
                    'personal_id' => $personal->id,
                    'fecha' => now()->subDays($i),
                    'estado' => fake()->randomElement(['presente_local', 'presente_domicilio', 'ausente']),

                    'observaciones' => fake()->boolean(30) ? fake()->sentence(4) : null,
                ]);
            }
        }
    }
}
