<?php

namespace Database\Factories;

use App\Models\Agenda;
use App\Models\Cliente;
use App\Models\Personal;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgendaFactory extends Factory
{
    protected $model = Agenda::class;

    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::inRandomOrder()->first()->id ?? Cliente::factory(),
            'personal_id' => Personal::inRandomOrder()->first()->id ?? Personal::factory(),
            'service_id' => Service::inRandomOrder()->first()->id ?? Service::factory(),
            'fecha' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'hora' => $this->faker->time('H:i'),
            'tipo_atencion' => $this->faker->randomElement(['salon', 'domicilio']),
            'estado' => $this->faker->randomElement(['pendiente', 'completado', 'cancelado']),
            'notas' => $this->faker->optional()->sentence(),
        ];
        
    }
}
