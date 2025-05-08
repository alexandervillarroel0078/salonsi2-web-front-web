<?php

namespace Database\Factories;

use App\Models\Combo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComboFactory extends Factory
{
    protected $model = Combo::class;

    public function definition(): array
    {
        $basePrice = $this->faker->randomFloat(2, 80, 200);
        $hasDiscount = $this->faker->boolean();

        return [
            'name' => $this->faker->words(3, true), // nombre aleatorio como "Paquete Belleza Express"
            'description' => $this->faker->paragraph(), // descripción más rica
            'price' => $basePrice,
            'discount_price' => $hasDiscount ? $basePrice - $this->faker->randomFloat(2, 10, 50) : null,
            'has_discount' => $hasDiscount,
            'image_path' => $this->faker->imageUrl(300, 200, 'fashion', true), // imagen aleatoria
            'active' => $this->faker->boolean(80), // 80% de probabilidad que esté activo
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Combo $combo) {
            $services = \App\Models\Service::where('has_available', true)
                ->inRandomOrder()
                ->take(rand(2, 4))
                ->get();

            if ($services->isNotEmpty()) {
                $combo->services()->attach($services->pluck('id'));
            }
        });
    }
}
