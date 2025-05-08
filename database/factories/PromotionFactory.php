<?php

namespace Database\Factories;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromotionFactory extends Factory
{
    protected $model = Promotion::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Descuento en Manicure y Pedicure',
                'Promoción Facial + Masaje Relajante',
                'Combo Especial Coloración de Cabello',
                'Oferta Express: Peinado y Maquillaje',
                'Semana de Descuentos en Alisados',
                'Promo Belleza Total',
                'Paquete Renovación de Imagen',
                'Promo Día de la Madre',
                'Especial Fin de Semana',
                'Mega Descuento en Servicios Capilares'
            ]),
            'description' => $this->faker->sentence(),
            'discount_percentage' => $this->faker->numberBetween(10, 50),
            'start_date' => now(),
            'end_date' => now()->addDays(rand(10, 30)),
            'active' => $this->faker->boolean(),

        ];
    }

    public function configure(): static
{
    return $this->afterCreating(function (Promotion $promotion) {
        logger("Creando promoción ID: {$promotion->id}");

        $services = \App\Models\Service::where('has_available', true)
            ->inRandomOrder()
            ->take(rand(1, 3))
            ->get();

        if ($services->isNotEmpty()) {
            logger("Asignando servicios a promoción ID: {$promotion->id}");
            $promotion->services()->attach($services->pluck('id'));
        } else {
            logger("No se encontraron servicios disponibles para promoción ID: {$promotion->id}");
        }
    });
}

}
