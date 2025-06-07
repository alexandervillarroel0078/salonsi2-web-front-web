<?php

namespace Database\Seeders;

use App\Models\CargoEmpleados;
use App\Models\Cliente;
use App\Models\Clasificadore;
use App\Models\Empleado;
use App\Models\User;
use App\Models\Combo;
use App\Models\ComboService;
use App\Models\Personal;
use App\Models\Service;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Database\Seeders\CargoEmpleadosSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RolesSeeder::class,
            UsuariosSeeder::class,
            ClasificadoresSeeder::class,
            CargoPersonalSeeder::class, 
          
 
            ComboSeeder::class,
            PersonalSeeder::class,
            ServiceSeeder::class,
            PromotionSeeder::class,
            ClienteSeeder::class,
            HorarioSeeder::class,
            
            AsistenciaSeeder::class,
            AgendaSeeder::class,
            PagoSeeder::class,
             
        ]);
    }
}
