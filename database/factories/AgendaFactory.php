<?php

namespace Database\Factories;

use App\Models\Agenda;
use App\Models\Cliente;
use App\Models\Personal;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgendaFactory extends Factory
{
    protected $model = Agenda::class;

    public function definition(): array
    {
        $tipoAtencion = $this->faker->randomElement(['salon', 'domicilio']);

        return [
            'cliente_id' => Cliente::inRandomOrder()->first()->id ?? Cliente::factory(),
            'personal_id' => Personal::inRandomOrder()->first()->id ?? Personal::factory(),
            'fecha' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'hora' => $this->faker->time('H:i'),
            'tipo_atencion' => $tipoAtencion,
            'ubicacion' => $tipoAtencion === 'salon' ? 'salón' : $this->faker->address,
            'estado' => $this->faker->randomElement([
                'pendiente',
                'confirmada',
                'en_curso',
                'finalizada',
                'cancelada'
            ]),
            'notas' => $this->faker->optional()->sentence(),
            'duracion' => 0,         // se recalcula luego
            'precio_total' => 0.00,  // se recalcula luego
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Agenda $agenda) {
            $servicios = \App\Models\Service::inRandomOrder()->take(rand(1, 3))->get();

            $agenda->servicios()->attach($servicios->pluck('id'));

            // Calcular duración total y precio total real
            $duracionTotal = $servicios->sum('duration_minutes');
            $precioTotal = $servicios->sum(function ($servicio) {
                return $servicio->has_discount ? $servicio->discount_price : $servicio->price;
            });

            // Actualizar la agenda con los valores calculados
            $agenda->update([
                'duracion' => $duracionTotal,
                'precio_total' => $precioTotal,
            ]);
        });
    }
}
