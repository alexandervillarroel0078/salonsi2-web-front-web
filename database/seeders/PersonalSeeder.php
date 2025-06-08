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

    $fotos = [
        'https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg',
        'https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg',
        'https://images.pexels.com/photos/774909/pexels-photo-774909.jpeg',
        'https://images.pexels.com/photos/2379005/pexels-photo-2379005.jpeg',
        'https://images.pexels.com/photos/936117/pexels-photo-936117.jpeg',
        'https://images.pexels.com/photos/323503/pexels-photo-323503.jpeg',
        'https://images.pexels.com/photos/614810/pexels-photo-614810.jpeg',
        'https://images.pexels.com/photos/91227/pexels-photo-91227.jpeg',
        'https://images.pexels.com/photos/733872/pexels-photo-733872.jpeg',
        'https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg',
    ];

    foreach (range(0, 9) as $i) {
        Personal::create([
            'name' => fake()->firstName() . ' ' . fake()->lastName() . ' ' . fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'photo_url' => $fotos[$i],
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
