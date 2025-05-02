<?php

namespace Database\Factories;

use App\Models\Horario;
use App\Models\Personal;
use Illuminate\Database\Eloquent\Factories\Factory;

class HorarioFactory extends Factory
{
    protected $model = Horario::class;

    public function definition()
    {
        return [
            'personal_id' => Personal::inRandomOrder()->first()->id,
            'date' => $this->faker->date(),
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(),
            'available' => $this->faker->boolean(),
        ];
    }
}
