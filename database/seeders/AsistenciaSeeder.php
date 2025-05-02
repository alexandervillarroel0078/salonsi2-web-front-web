<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asistencia;

class AsistenciaSeeder extends Seeder {
    public function run(): void {
        \App\Models\Personal::factory(5)->create()->each(function ($personal) {
            Asistencia::factory(3)->create([ 'personal_id' => $personal->id ]);
        });
    }
}