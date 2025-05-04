<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    protected $folder = 'salon_backup'; // Carpeta correcta

    public function index()
    {
        $disk = Storage::disk('local');
        $files = collect($disk->files($this->folder));

        $backups = $files->map(function ($file) use ($disk) {
            return [
                'name' => basename($file),
                'size' => $disk->size($file),
                'date' => $disk->lastModified($file),
            ];
        })->sortByDesc('date');

        return view('backups.index', compact('backups'));
    }

    public function download($fileName)
    {
        $path = "{$this->folder}/{$fileName}";
        $disk = Storage::disk('local');

        if ($disk->exists($path)) {
            return response()->download(storage_path("app/{$path}"));
        }

        return redirect()->back()->with('error', 'Archivo no encontrado');
    }

    public function run()
    {
        try {
            // Ejecuta el comando y captura salida
            $exitCode = Artisan::call('backup:run');
            $output = Artisan::output();
    
            // Mostrar directamente qué se ejecutó y qué devolvió
            echo "<pre>";
            echo "🔧 Código de salida: $exitCode\n\n";
            echo "📝 Salida del comando:\n";
            print_r($output);
            echo "</pre>";
    
            // Buscar el archivo generado
            $files = collect(Storage::disk('local')->allFiles())
                ->filter(fn($file) => str_ends_with($file, '.zip'))
                ->sortByDesc(fn($file) => Storage::disk('local')->lastModified($file))
                ->values();
    
            echo "<pre>📦 Archivos ZIP encontrados:\n";
            print_r($files->toArray());
            echo "</pre>";
    
            if ($files->isEmpty()) {
                exit("❌ No se generó ningún archivo de backup.");
            }
    
            $latest = $files->first();
    
            if (!str_starts_with($latest, 'salon_backup/')) {
                Storage::disk('local')->move($latest, 'salon_backup/' . basename($latest));
                echo "✅ Backup movido a carpeta salon_backup/<br>";
            }
    
            exit("✅ Backup generado correctamente.");
        } catch (\Throwable $e) {
            dd("❌ ERROR al generar backup:", $e->getMessage());
        }
    }
    






    public function destroy($fileName)
    {
        $path = "{$this->folder}/{$fileName}";

        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
            return redirect()->back()->with('success', 'Backup eliminado');
        }

        return redirect()->back()->with('error', 'Archivo no encontrado');
    }

    public function restoreDatabase($fileName)
    {
        $path = "salon_backup/{$fileName}";
        $disk = Storage::disk('local');

        if (!$disk->exists($path)) {
            return redirect()->back()->with('error', 'Archivo de backup no encontrado');
        }

        $zipPath = storage_path("app/{$path}");
        $extractPath = storage_path('app/restore-temp');

        // Crear carpeta si no existe y limpiarla
        if (!is_dir($extractPath)) {
            mkdir($extractPath, 0755, true);
        }

        foreach (glob("{$extractPath}/*") as $file) {
            unlink($file);
        }

        // Extraer el ZIP
        $zip = new \ZipArchive;
        if ($zip->open($zipPath) === TRUE) {
            $zip->extractTo($extractPath);
            $zip->close();
        } else {
            return redirect()->back()->with('error', 'No se pudo abrir el archivo ZIP');
        }

        // Buscar el archivo .sql
        $sqlFiles = glob("{$extractPath}/*.sql");
        if (empty($sqlFiles)) {
            return redirect()->back()->with('error', 'No se encontró ningún archivo .sql dentro del backup');
        }

        $sqlFile = $sqlFiles[0];

        // Datos de conexión
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', '3306');

        // Ruta a mysql.exe (ajustado para XAMPP)
        $mysqlPath = 'C:\\xampp\\mysql\\bin\\mysql.exe';

        // Comando
        $command = "\"{$mysqlPath}\" -h {$dbHost} -P {$dbPort} -u {$dbUser} " .
            ($dbPass ? "-p\"{$dbPass}\" " : "") .
            "{$dbName} < \"{$sqlFile}\"";

        // Ejecutar
        $output = null;
        $result = null;
        exec($command, $output, $result);

        if ($result === 0) {
            return redirect()->back()->with('success', 'Base de datos restaurada correctamente');
        }

        return redirect()->back()->with('error', 'Error al restaurar la base de datos');
    }
}
