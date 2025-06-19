<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Personal;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class PersonalServiceSeeder extends Seeder
{
 public function run(): void
    {
        DB::table('personal_service')->truncate();

        $personales = Personal::all();
        $servicios = Service::all();

        // Paso 1: asignar entre 2 y 4 servicios a cada personal
        foreach ($personales as $personal) {
            $serviciosAleatorios = $servicios->random(rand(2, 4))->pluck('id')->toArray();

            foreach ($serviciosAleatorios as $servicio_id) {
                DB::table('personal_service')->insertOrIgnore([
                    'personal_id' => $personal->id,
                    'service_id' => $servicio_id,
                    'comision_porcentaje' => rand(5, 15),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Paso 2: asegurar que cada servicio tenga al menos un personal
        foreach ($servicios as $servicio) {
            $asignados = DB::table('personal_service')->where('service_id', $servicio->id)->count();

            if ($asignados === 0) {
                $personalRandom = $personales->random();
                DB::table('personal_service')->insert([
                    'personal_id' => $personalRandom->id,
                    'service_id' => $servicio->id,
                    'comision_porcentaje' => rand(5, 15),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
