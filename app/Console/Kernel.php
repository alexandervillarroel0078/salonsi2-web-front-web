<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\BackupDatabaseCommand;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\VerBitacora::class,
         BackupDatabaseCommand::class,
    ];

    // ✅ Programar tareas automáticas
    protected function schedule(Schedule $schedule)
    {
        // Backup automático todos los lunes a las 2:00 AM
       // $schedule->command('backup:run')->everyMinute(); // Solo para pruebas
       $schedule->command('backup:run')->weeklyOn(1, '02:00');


    }

    // ✅ Cargar comandos automáticamente
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
