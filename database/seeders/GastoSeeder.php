<?php

namespace Database\Seeders;

use App\Models\Gasto;
use App\Models\CategoriaGasto;
use App\Models\User;
use Illuminate\Database\Seeder;

class GastoSeeder extends Seeder
{
    public function run()
    {
        $catId = CategoriaGasto::inRandomOrder()->first()->id;
        $userId = User::first()?->id ?? 1;

        Gasto::create([
            'detalle' => 'Compra de shampoo',
            'monto' => 150.00,
            'fecha' => now()->subDays(3),
            'categoria_gasto_id' => $catId,
            'agenda_id' => null,
            'user_id' => $userId,
        ]);

        Gasto::create([
            'detalle' => 'Pago transporte del personal',
            'monto' => 70.00,
            'fecha' => now()->subDay(),
            'categoria_gasto_id' => $catId,
            'agenda_id' => null,
            'user_id' => $userId,
        ]);
    }
}
