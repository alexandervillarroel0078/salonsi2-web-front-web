<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

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
            $exitCode = Artisan::call('backup:run');
            $output = Artisan::output();
            Log::info("Backup ejecutado: ", ['exit_code' => $exitCode, 'output' => $output]);

            $files = collect(Storage::disk('local')->allFiles())
                ->filter(fn($file) => str_ends_with($file, '.zip'))
                ->sortByDesc(fn($file) => Storage::disk('local')->lastModified($file))
                ->values();

            if ($files->isEmpty()) {
                Log::error("No se generó ningún archivo de backup.");
                exit("❌ No se generó ningún archivo de backup.");
            }

            $latest = $files->first();
            echo "✅ Backup generado correctamente en: $latest";
            exit;
        } catch (\Throwable $e) {
            Log::error("Error en backup: " . $e->getMessage());
            echo "<pre>❌ ERROR al generar backup:\n" . $e->getMessage() . "</pre>";
            exit;
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

        if (!is_dir($extractPath)) {
            mkdir($extractPath, 0755, true);
        }

        foreach (glob("{$extractPath}/*") as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        $zip = new \ZipArchive;
        if ($zip->open($zipPath) === TRUE) {
            $zip->extractTo($extractPath);
            $zip->close();
        } else {
            return redirect()->back()->with('error', 'No se pudo abrir el archivo ZIP');
        }

        $sqlFiles = glob("{$extractPath}/*.sql");
        if (empty($sqlFiles)) {
            return redirect()->back()->with('error', 'No se encontró ningún archivo .sql dentro del backup');
        }

        $sqlFile = $sqlFiles[0];

        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', '3306');
        $mysqlPath = env('MYSQL_PATH', 'C:\\xampp\\mysql\\bin\\mysql.exe');

        $command = "\"{$mysqlPath}\" -h {$dbHost} -P {$dbPort} -u {$dbUser} " .
            ($dbPass ? "-p\"{$dbPass}\" " : "") .
            "{$dbName} < \"{$sqlFile}\"";

        $output = null;
        $result = null;
        exec($command, $output, $result);

        if ($result === 0) {
            Log::info("Base de datos restaurada desde {$fileName}");
            return redirect()->back()->with('success', 'Base de datos restaurada correctamente');
        }

        Log::error("Error al restaurar la base de datos desde {$fileName}");
        return redirect()->back()->with('error', 'Error al restaurar la base de datos');
    }
}
