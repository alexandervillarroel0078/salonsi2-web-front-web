<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Facades\Response;

class ExportServiceController extends Controller
{
    public function exportCSV()
    {
        $services = Service::all(['id', 'name', 'price', 'discount_price']);

         $filename = 'servicios.csv';
   //    $filename = 'servicios.xls'; // ← en lugar de servicios.csv

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function() use ($services) {
            $file = fopen('php://output', 'w');
            // Encabezados del CSV
            fputcsv($file, ['ID', 'Nombre', 'Precio', 'Descuento']);

            foreach ($services as $service) {
                fputcsv($file, [
                    $service->id,
                    $service->name,
                    $service->price,
                    $service->discount_price,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}

