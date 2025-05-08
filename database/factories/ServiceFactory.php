<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $names = [
            'Corte de cabello',
            'Peinado profesional',
            'Coloración de cabello',
            'Manicure básica',
            'Pedicure spa',
            'Tratamiento facial',
            'Depilación de cejas',
            'Masaje relajante',
            'Maquillaje social',
            'Alisado de cabello'
        ];

        // Map de nombres a imágenes (puedes cambiar el origen luego)
        $imageMap = [];
        foreach ($names as $name) {
            $imageMap[$name] = 'https://randomuser.me/api/portraits/women/' . $this->faker->numberBetween(1, 99) . '.jpg';
        }

        $name = $this->faker->randomElement($names);

        return [
            'name' => $name,
            'description' => $this->faker->sentence(10),
            'category' => $this->faker->randomElement(['Cabello', 'Uñas', 'Facial', 'Relajación', 'Maquillaje']),
            'image_path' => $imageMap[$name],
            'price' => $this->faker->numberBetween(30, 150),
            'discount_price' => $this->faker->numberBetween(10, 120),
            'has_discount' => $this->faker->boolean(40),
            'has_available' => $this->faker->boolean(90),
            'duration_minutes' => $this->faker->randomElement([30, 45, 60, 90]),
            'tipo_atencion' => $this->faker->randomElement(['salon', 'domicilio']),
            'specialist_id' => null, // Si luego haces seeders de especialistas, aquí puedes asignar uno aleatorio
        ];
    }
}
