<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Combo>
 */
class ComboFactory extends Factory
{
    public function definition(): array
    {
        $hasDiscount = $this->faker->boolean(70); // 70% probabilidad de tener descuento
    
        return [
            'name' => $this->faker->randomElement([
                'Pack Manicure y Pedicure Spa',
                'Combo Facial + Masaje Relajante',
                'Día de Belleza Completo',
                'Color + Corte + Peinado',
                'Promoción Novia Premium',
            ]),
            'price' => $this->faker->numberBetween(100, 200),
            'discount_price' => $hasDiscount
                ? $this->faker->numberBetween(50, 99)
                : 0,
            'has_discount' => $hasDiscount,
            'image_path' => null,
        ];
    }
    
}
