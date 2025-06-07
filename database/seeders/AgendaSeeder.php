<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agenda;
use App\Models\Cliente;
use App\Models\Service;
use App\Models\Personal;

class AgendaSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::all();
        $servicios = Service::all();
        $personal = Personal::all();

        if ($clientes->isEmpty() || $servicios->isEmpty() || $personal->isEmpty()) {
            $this->command->warn('Se necesitan clientes, servicios y personal para poblar agendas.');
            return;
        }

        for ($i = 0; $i < 5; $i++) {
            $cliente = $clientes->random();
            $agenda = Agenda::create([
                'codigo' => 'AG-' . strtoupper(fake()->unique()->bothify('###??')),
                'fecha' => fake()->date(),
                'hora' => fake()->time('H:i'),
                'tipo_atencion' => fake()->randomElement(['salon', 'domicilio']),
                'ubicacion' => fake()->address(),
                'estado' => fake()->randomElement(['pendiente', 'confirmada', 'en_curso']),
                'notas' => fake()->sentence(8),
                'duracion' => fake()->randomElement([30, 60, 90]),
                'precio_total' => 0, // se suma después
            ]);

            // Asignar cliente (pivot)
            $agenda->clientes()->attach($cliente->id);

            // Asignar servicios con personal (pivot)
            $serviciosSeleccionados = $servicios->random(rand(1, 3));

            $precioTotal = 0;

            foreach ($serviciosSeleccionados as $servicio) {
                $especialista = $personal->random();
                $agenda->servicios()->attach($servicio->id, [
                    'personal_id' => $especialista->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $precioTotal += $servicio->has_discount ? $servicio->discount_price : $servicio->price;
            }

            // Actualizar total
            $agenda->update(['precio_total' => $precioTotal]);
        }
    }
}
