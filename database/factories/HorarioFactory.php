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
    $startHour = $this->faker->numberBetween(6, 18); // 6am a 6pm
    $startMinute = $this->faker->randomElement([0, 15, 30, 45]);
    $start = sprintf('%02d:%02d', $startHour, $startMinute);

    $duration = $this->faker->numberBetween(1, 4); // hasta 4 horas más tarde
    $endHour = $startHour + $duration;
    $end = sprintf('%02d:%02d', min($endHour, 23), $startMinute);

    return [
        'personal_id' => \App\Models\Personal::inRandomOrder()->first()?->id ?? \App\Models\Personal::factory(),
        'day_name' => $this->faker->randomElement(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']),
        'date' => $this->faker->date(),
        'start_time' => $start,
        'end_time' => $end,
        'available' => $this->faker->boolean(90),
    ];
}

}
