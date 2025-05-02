<?php
// database/factories/ComboFactory.php

namespace Database\Factories;

use App\Models\Combo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComboFactory extends Factory
{
    protected $model = Combo::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'discount_price' => $this->faker->randomFloat(2, 5, 50),
            'has_discount' => $this->faker->boolean(),
            'image_path' => 'https://via.placeholder.com/150'
        ];
    }
}
