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

        // Aquí puedes asociar cada nombre con una URL de imagen única
        $imageMap = [
            'Corte de cabello' => 'https://randomuser.me/api/portraits/women/' . $this->faker->numberBetween(1, 99) . '.jpg',
            'Peinado profesional' => 'https://randomuser.me/api/portraits/women/' . $this->faker->numberBetween(1, 99) . '.jpg',
            'Coloración de cabello' => 'https://randomuser.me/api/portraits/women/' . $this->faker->numberBetween(1, 99) . '.jpg',
            'Manicure básica' => 'https://randomuser.me/api/portraits/women/' . $this->faker->numberBetween(1, 99) . '.jpg',
            'Pedicure spa' => 'https://randomuser.me/api/portraits/women/' . $this->faker->numberBetween(1, 99) . '.jpg',
            'Tratamiento facial' => 'https://randomuser.me/api/portraits/women/' . $this->faker->numberBetween(1, 99) . '.jpg',
            'Depilación de cejas' => 'https://randomuser.me/api/portraits/women/' . $this->faker->numberBetween(1, 99) . '.jpg',
            'Masaje relajante' => 'https://randomuser.me/api/portraits/women/' . $this->faker->numberBetween(1, 99) . '.jpg',
            'Maquillaje social' => 'https://randomuser.me/api/portraits/women/' . $this->faker->numberBetween(1, 99) . '.jpg',
            'Alisado de cabello' => 'https://randomuser.me/api/portraits/women/' . $this->faker->numberBetween(1, 99) . '.jpg',
        ];

        $name = $this->faker->randomElement($names);
        
        return [
            'name' => $name,
            'description' => $this->faker->sentence(10),
            'category' => $this->faker->randomElement(['Cabello', 'Uñas', 'Facial', 'Relajación', 'Maquillaje']),
            'image_path' => $imageMap[$name], // Asignamos la imagen dinámica de RandomUser.me
            'price' => $this->faker->numberBetween(30, 150),
            'discount_price' => $this->faker->numberBetween(10, 120),
            'has_discount' => $this->faker->boolean(40),
            'has_available' => $this->faker->boolean(90),
            'duration_minutes' => $this->faker->randomElement([30, 45, 60, 90]),
        ];
    }
}
