<?php
namespace Database\Factories;

use App\Models\Asistencia;
use App\Models\Personal;
use Illuminate\Database\Eloquent\Factories\Factory;

class AsistenciaFactory extends Factory {
    protected $model = Asistencia::class;

    public function definition(): array {
        return [
            'personal_id' => Personal::factory(),
            'fecha' => $this->faker->date(),
            'estado' => $this->faker->randomElement(['presente_local', 'presente_domicilio', 'ausente']),
            'observaciones' => $this->faker->optional()->sentence()
        ];
    }
}