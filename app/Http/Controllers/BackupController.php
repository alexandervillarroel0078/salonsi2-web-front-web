<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class BackupController extends Controller
{
    public function index()
    {
        $files = Storage::disk('local')->files('backups');
        $backups = collect($files)->map(function ($file) {
            return [
                'name' => basename($file),
                'size' => Storage::disk('local')->size($file),
                'date' => Storage::disk('local')->lastModified($file),
            ];
        })->sortByDesc('date');

        return view('backups.index', compact('backups'));
    }

    public function run()
    {
        try {
            $dbName = env('DB_DATABASE');
            $tables = DB::select('SHOW TABLES');
            $sqlDump = "-- Backup generado: " . now() . "\n\n";

            foreach ($tables as $table) {
                $tableName = array_values((array)$table)[0];

                // Estructura
                $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0]->{'Create Table'};
                $sqlDump .= "DROP TABLE IF EXISTS `$tableName`;\n$createTable;\n\n";

                // Datos
                $rows = DB::table($tableName)->get();
                foreach ($rows as $row) {
                    $values = array_map(function ($value) {
                        return is_null($value) ? 'NULL' : "'" . addslashes($value) . "'";
                    }, (array)$row);
                    $sqlDump .= "INSERT INTO `$tableName` VALUES (" . implode(",", $values) . ");\n";
                }
                $sqlDump .= "\n\n";
            }

            $fileName = 'backup_' . date('Ymd_His') . '.sql';
            Storage::disk('local')->put("backups/$fileName", $sqlDump);

            return back()->with('success', 'Backup generado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function download($filename)
    {
        return Storage::disk('local')->download("backups/$filename");
    }

    public function destroy($filename)
    {
        Storage::disk('local')->delete("backups/$filename");
        return back()->with('success', 'Backup eliminado correctamente.');
    }
}
