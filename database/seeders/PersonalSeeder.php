<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Personal;
use App\Models\CargoPersonal;
use Illuminate\Support\Facades\DB;

class PersonalSeeder extends Seeder
{
    public function run(): void
    {
        $cargos = CargoPersonal::all();

        foreach (range(1, 10) as $i) {
            Personal::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'photo_url' => fake()->imageUrl(300, 300, 'people', true),
                'fecha_ingreso' => now()->subDays(rand(30, 300)),
                'descripcion' => fake()->sentence(12),
                'instagram' => '@' . fake()->userName(),
                'facebook' => fake()->userName(),
                'status' => true,
                'cargo_personal_id' => $cargos->random()->id,
            ]);
        }
    }
}
