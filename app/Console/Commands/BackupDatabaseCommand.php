<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class BackupDatabaseCommand extends Command
{
    protected $signature = 'backup:daily';
    protected $description = 'Realiza una copia de seguridad diaria de la base de datos';

    public function handle()
    {
        try {
            Artisan::call('backup:run');
            $this->info('✅ Backup realizado con éxito');
            Log::info('Backup automático realizado correctamente.');
        } catch (\Throwable $e) {
            $this->error('❌ Error en el backup: ' . $e->getMessage());
            Log::error('Error en backup automático: ' . $e->getMessage());
        }
    }
}
