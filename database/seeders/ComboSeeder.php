<?php

namespace Database\Seeders;

use App\Models\Combo;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ComboSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creamos 10 combos
        Combo::factory()
            ->count(10)
            ->create()
            ->each(function ($combo) {
                // A cada combo le asignamos entre 2 a 5 servicios aleatorios
                $services = Service::inRandomOrder()->take(rand(2, 5))->pluck('id');
                $combo->services()->sync($services);
            });
    }
}
