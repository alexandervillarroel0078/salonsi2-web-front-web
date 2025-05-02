<?php
// database/seeders/ComboServiceSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Combo;
use App\Models\Service;

class ComboServiceSeeder extends Seeder
{
    public function run(): void
    {
        $combos = Combo::all();  // Obtener todos los combos
        $services = Service::all();  // Obtener todos los servicios

        foreach ($combos as $combo) {
            // Asignamos aleatoriamente 3 servicios a cada combo (puedes ajustar la cantidad)
            $combo->services()->attach(
                $services->random(3)->pluck('id')->toArray()
            );
        }
    }
}
