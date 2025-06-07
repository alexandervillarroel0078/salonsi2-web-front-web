<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        $promociones = [
            [
                'name' => 'Promo de Verano',
                'description' => 'Obtén un 20% de descuento en todos los servicios de coloración.',
                'discount_percentage' => 20.00,
                'start_date' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
                'active' => true,
            ],
            [
                'name' => 'Pack Fin de Semana',
                'description' => '15% de descuento en cortes y peinados los sábados y domingos.',
                'discount_percentage' => 15.00,
                'start_date' => Carbon::now()->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'active' => true,
            ],
            [
                'name' => 'Día de la Madre',
                'description' => '30% de descuento solo por el 27 de mayo.',
                'discount_percentage' => 30.00,
                'start_date' => '2025-05-27',
                'end_date' => '2025-05-27',
                'active' => false,
            ],
        ];

        foreach ($promociones as $promo) {
            Promotion::create($promo);
        }
    }
}
