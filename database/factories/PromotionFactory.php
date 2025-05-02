<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromotionFactory extends Factory
{
    use HasFactory;

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
            'description' => $this->faker->randomElement([
                'Obtén un 20% de descuento en todos los servicios de manicure y pedicure.',
                'Disfruta un facial profundo y masaje relajante a un precio especial.',
                'Renueva tu look con un paquete de coloración de cabello.',
                'Peinado profesional y maquillaje social con 15% de descuento.',
                'Semana especial: alisados capilares a precio reducido.',
                'Transforma tu imagen con nuestros paquetes exclusivos.',
                'Celebra el Día de la Madre con nuestros mejores servicios.',
                'Aprovecha promociones especiales este fin de semana.',
                'Descubre nuestras ofertas en cuidado capilar.',
                'Descuentos imperdibles en todos nuestros servicios de salón.'
            ]),
            'discount_percentage' => $this->faker->numberBetween(10, 50),
            'start_date' => now(),
            'end_date' => now()->addDays(rand(10, 30)),
            'active' => true,
        ];
    }
}
