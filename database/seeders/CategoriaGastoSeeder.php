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
        ];

        foreach ($categorias as $cat) {
            CategoriaGasto::create($cat);
        }
    }
}