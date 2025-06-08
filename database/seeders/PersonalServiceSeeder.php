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
        DB::table('personal_service')->truncate(); // limpia si hace falta

        $personales = Personal::all();
        $servicios = Service::all();

        foreach ($personales as $personal) {
            // Asignar entre 2 y 4 servicios aleatorios a cada personal
            $serviciosAleatorios = $servicios->random(rand(2, 4))->pluck('id')->toArray();

            foreach ($serviciosAleatorios as $servicio_id) {
                DB::table('personal_service')->insert([
                    'personal_id' => $personal->id,
                    'service_id' => $servicio_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
