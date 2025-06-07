<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // Cabello
            [
                'name' => 'Corte de cabello',
                'category' => 'Cabello',
                'image_path' => 'https://images.pexels.com/photos/3993449/pexels-photo-3993449.jpeg',
            ],
            [
                'name' => 'Coloración de cabello',
                'category' => 'Cabello',
                'image_path' => 'https://images.pexels.com/photos/3993444/pexels-photo-3993444.jpeg',
            ],
            [
                'name' => 'Tratamiento de keratina',
                'category' => 'Cabello',
                'image_path' => 'https://images.pexels.com/photos/3993446/pexels-photo-3993446.jpeg?auto=compress&cs=tinysrgb&w=600',
            ],

            // Uñas
            [
                'name' => 'Manicure básica',
                'category' => 'Uñas',
                'image_path' => 'https://images.pexels.com/photos/3997389/pexels-photo-3997389.jpeg',
            ],
            [
                'name' => 'Pedicure spa',
                'category' => 'Uñas',
                'image_path' => 'https://images.pexels.com/photos/4210657/pexels-photo-4210657.jpeg?auto=compress&cs=tinysrgb&w=600',
            ],
            [
                'name' => 'Uñas acrílicas',
                'category' => 'Uñas',
                'image_path' => 'https://images.pexels.com/photos/3997386/pexels-photo-3997386.jpeg?auto=compress&cs=tinysrgb&w=600',
            ],

            // Facial
            [
                'name' => 'Tratamiento facial',
                'category' => 'Facial',
                'image_path' => 'https://images.pexels.com/photos/5240820/pexels-photo-5240820.jpeg?auto=compress&cs=tinysrgb&w=600',
            ],
            [
                'name' => 'Limpieza facial profunda',
                'category' => 'Facial',
                'image_path' => 'https://images.pexels.com/photos/3151296/pexels-photo-3151296.jpeg?auto=compress&cs=tinysrgb&w=600',
            ],
            [
                'name' => 'Mascarilla facial nutritiva',
                'category' => 'Facial',
                'image_path' => 'https://images.pexels.com/photos/5119214/pexels-photo-5119214.jpeg?auto=compress&cs=tinysrgb&w=600',
            ],

            // Relajación
            [
                'name' => 'Masaje relajante',
                'category' => 'Relajación',
                'image_path' => 'https://images.pexels.com/photos/6560304/pexels-photo-6560304.jpeg?auto=compress&cs=tinysrgb&w=600',
            ],
            [
                'name' => 'Peeling facial',
                'category' => 'Relajación',
                'image_path' => 'https://images.pexels.com/photos/5240836/pexels-photo-5240836.jpeg?auto=compress&cs=tinysrgb&w=600',
            ],
            [
                'name' => 'Masaje craneal',
                'category' => 'Relajación',
                'image_path' => 'https://images.pexels.com/photos/3212164/pexels-photo-3212164.jpeg?auto=compress&cs=tinysrgb&w=600',
            ],

            // Maquillaje
            [
                'name' => 'Peinado profesional',
                'category' => 'Maquillaje',
                'image_path' => 'https://images.pexels.com/photos/973403/pexels-photo-973403.jpeg?auto=compress&cs=tinysrgb&w=600',
            ],
            [
                'name' => 'Maquillaje social',
                'category' => 'Maquillaje',
                'image_path' => 'https://images.pexels.com/photos/6001507/pexels-photo-6001507.jpeg?auto=compress&cs=tinysrgb&w=600',
            ],
            [
                'name' => 'Tinte de cejas',
                'category' => 'Maquillaje',
                'image_path' => 'https://images.pexels.com/photos/3738340/pexels-photo-3738340.jpeg?auto=compress&cs=tinysrgb&w=600',
            ],
        ];

        foreach ($services as $service) {
            $price = fake()->numberBetween(30, 150);
            $hasDiscount = fake()->boolean(40);
            $discountPrice = $hasDiscount ? round($price * 0.90) : $price;

            Service::create([
                'name' => $service['name'],
                'description' => fake()->sentence(10),
                'category' => $service['category'],
                'image_path' => $service['image_path'],
                'price' => $price,
                'discount_price' => $discountPrice,
                'has_discount' => $hasDiscount,
                'has_available' => fake()->boolean(90),
                'duration_minutes' => fake()->randomElement([30, 45, 60, 90]),
                'tipo_atencion' => fake()->randomElement(['salon', 'domicilio']),
            ]);
        }
    }
}
