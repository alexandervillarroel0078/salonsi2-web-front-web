<?php
// database/seeders/ComboSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Combo;

class ComboSeeder extends Seeder
{
    public function run(): void
    {
        Combo::factory()->count(5)->create();
    }
}
