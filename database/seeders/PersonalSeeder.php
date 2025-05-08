<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Personal;

class PersonalSeeder extends Seeder
{
    public function run(): void
    {
        Personal::factory()->count(20)->create();

    }
}