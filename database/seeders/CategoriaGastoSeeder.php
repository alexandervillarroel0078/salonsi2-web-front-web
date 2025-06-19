<?php

namespace Database\Seeders;

use App\Models\CategoriaGasto;
use Illuminate\Database\Seeder;

class CategoriaGastoSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            ['nombre' => 'Sueldos', 'descripcion' => 'Pago de personal'],
            ['nombre' => 'Viáticos', 'descripcion' => 'Transporte y comida'],
            ['nombre' => 'Insumos', 'descripcion' => 'Materiales y productos'],
            ['nombre' => 'Pago de comisiones', 'descripcion' => 'comisioines para el personal'],
        ];

        foreach ($categorias as $cat) {
            CategoriaGasto::firstOrCreate(['nombre' => $cat['nombre']], $cat);
        }
    }
}
