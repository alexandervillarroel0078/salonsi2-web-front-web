<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;


class ExportAgendaController extends Controller
{
    public function exportCSV()
    {
        $agendas = Agenda::with(['cliente', 'personal'])->get();

        $filename = 'agendas.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($agendas) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Fecha', 'Hora', 'Cliente', 'Personal', 'Estado']);

            foreach ($agendas as $agenda) {
                fputcsv($file, [
                    $agenda->id,
                    $agenda->fecha,
                    $agenda->hora,
                    $agenda->cliente->name ?? 'Sin cliente',
                    $agenda->personal->name ?? 'Sin personal',
                    ucfirst($agenda->estado),
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportExcel()
    {
        $agendas = Agenda::with(['cliente', 'personal'])->get();

        $filename = 'agendas.xls'; // No cambiaste este nombre correctamente en tu versión

        $headers = [
            "Content-type" => "application/vnd.ms-excel", // Tipo de contenido más apropiado para Excel
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($agendas) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Fecha', 'Hora', 'Cliente', 'Personal', 'Estado']);

            foreach ($agendas as $agenda) {
                fputcsv($file, [
                    $agenda->id,
                    $agenda->fecha,
                    $agenda->hora,
                    $agenda->cliente->name ?? 'Sin cliente',
                    $agenda->personal->name ?? 'Sin personal',
                    ucfirst($agenda->estado),
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

   public function export(Request $request)
{
    $format = $request->input('format');

    return match ($format) {
        'csv' => $this->exportCSV(),
        'excel' => $this->exportExcel(),
        'pdf' => $this->exportPDF(),
        'html' => $this->exportHTML(),
        default => back()->with('error', 'Formato no válido'),
    };
}

}
