<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupDatabaseCommand extends Command
{
    protected $signature = 'backup:run';
    protected $description = 'Genera un respaldo automático de la base de datos';

    public function handle()
    {
         Storage::disk('local')->append('backups/cron_log.txt', 'INTENTANDO ejecutar backup: ' . now());

        try {
            $dbName = env('DB_DATABASE');
            $tables = DB::select('SHOW TABLES');
            $sqlDump = "-- Backup generado automáticamente: " . now() . "\n\n";

            foreach ($tables as $table) {
                $tableName = array_values((array)$table)[0];
                $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0]->{'Create Table'};
                $sqlDump .= "DROP TABLE IF EXISTS `$tableName`;\n$createTable;\n\n";

                $rows = DB::table($tableName)->get();
                foreach ($rows as $row) {
                    $values = array_map(function ($value) {
                        return is_null($value) ? 'NULL' : "'" . addslashes($value) . "'";
                    }, (array)$row);
                    $sqlDump .= "INSERT INTO `$tableName` VALUES (" . implode(",", $values) . ");\n";
                }
                $sqlDump .= "\n\n";
            }

            $fileName = 'auto_backup_' . date('Ymd_His') . '.sql';
            Storage::disk('local')->put("backups/$fileName", $sqlDump);

            $this->info('✅ Backup generado automáticamente.');
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
        }
    }
}
