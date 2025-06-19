<?php

namespace Database\Seeders;

use App\Models\Comision;
use App\Models\Agenda;
use App\Models\Service;
use App\Models\Personal;
use Illuminate\Database\Seeder;

class ComisionSeeder extends Seeder
{
    public function run()
    {
        $agenda = Agenda::first();
        $servicio = Service::first();
        $personal = Personal::first();

        if ($agenda && $servicio && $personal) {
            Comision::create([
                'agenda_id' => $agenda->id,
                'service_id' => $servicio->id,
                'personal_id' => $personal->id,
                'monto' => 35.00,
                'estado' => 'pendiente',
                'fecha_pago' => null,
                'metodo_pago' => null,
                'observaciones' => 'Comisión por corte básico',
            ]);
        }
    }
}
