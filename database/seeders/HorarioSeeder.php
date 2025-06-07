<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horario;
use App\Models\Personal;
use Carbon\Carbon;

class HorarioSeeder extends Seeder
{
    public function run(): void
    {
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        foreach (Personal::all() as $personal) {
            foreach ($dias as $i => $dia) {
                $fecha = Carbon::now()->startOfWeek()->addDays($i);

                Horario::create([
                    'personal_id' => $personal->id,
                    'day_name' => $dia,
                    'date' => $fecha->toDateString(),
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                    'available' => true,
                ]);
            }
        }
    }
}
