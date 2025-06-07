<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pago;
use App\Models\Agenda;
use App\Models\Cliente;

class PagoSeeder extends Seeder
{
    public function run(): void
    {
        $agendas = Agenda::all();

        if ($agendas->isEmpty()) {
            $this->command->warn('No hay agendas disponibles para generar pagos.');
            return;
        }

        foreach ($agendas as $agenda) {
            // Buscar cliente asociado a esta agenda (pivot agenda_cliente)
            $cliente = $agenda->clientes()->first();

            if (!$cliente) {
                continue; // saltar si no hay cliente
            }

            Pago::create([
                'monto' => $agenda->precio_total,
                'estado' => fake()->randomElement(['pagado', 'pendiente']),
                'metodo_pago' => fake()->randomElement(['efectivo', 'tarjeta', 'transferencia']),
                'agenda_id' => $agenda->id,
                'cliente_id' => $cliente->id,
            ]);
        }
    }
}
