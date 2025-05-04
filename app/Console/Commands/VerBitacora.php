<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class VerBitacora extends Command
{
    // Nombre del comando personalizado
    protected $signature = 'bitacora:ver {--key=}';


    protected $description = 'Ver el contenido del archivo de bitácora confidencial';

    public function handle()
    {
        if (env('DEVELOPER_KEY') !== $this->option('key')) {
            $this->error('Clave no autorizada para ver la bitácora.');
            return;
        }
        $path = storage_path('logs/bitacora.log');

        if (!File::exists($path)) {
            $this->error('El archivo bitacora.log no existe.');
            return;
        }

        $contenido = File::get($path);

        if (empty($contenido)) {
            $this->info('La bitácora está vacía.');
        } else {
            $this->line($contenido);
        }
    }
}
