<?php

namespace Database\Factories;

use App\Models\Personal;
use App\Models\CargoPersonal;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;

class PersonalFactory extends Factory
{
    protected $model = Personal::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'photo_url' => 'https://randomuser.me/api/portraits/' . $this->faker->randomElement(['women', 'men']) . '/' . $this->faker->numberBetween(1, 99) . '.jpg',
            'fecha_ingreso' => $this->faker->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
            'descripcion' => $this->faker->sentence(10),
            'instagram' => 'https://instagram.com/' . $this->faker->userName(),
            'facebook' => 'https://facebook.com/' . $this->faker->userName(),
            'status' => $this->faker->boolean(90),
            'cargo_personal_id' => CargoPersonal::inRandomOrder()->first()?->id,

        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Personal $personal) {
            $servicios = Service::inRandomOrder()->take(rand(1, 4))->pluck('id');
            $personal->services()->attach($servicios);
        });
    }
}
