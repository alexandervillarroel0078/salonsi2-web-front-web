<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Cliente;
use App\Models\Service;
use App\Models\Personal;
use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AgendaController extends Controller
{
    use BitacoraTrait;

    public function index(Request $request)
    {
        $agendas = $this->filtrarAgendas($request);
        $clientes = \App\Models\Cliente::orderBy('name')->get();
        $personales = \App\Models\Personal::orderBy('name')->get();

        return view('agendas.index', compact('agendas', 'clientes', 'personales'));
    }
    private function filtrarAgendas(Request $request)
    {
        $query = Agenda::with(['clientes', 'personal', 'servicios']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('clientes', fn($sub) =>
                $sub->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%"))
                    ->orWhereHas('personal', fn($sub) =>
                    $sub->where('name', 'like', "%$search%"));
            });
        }

        if ($request->filled('fecha')) {
            $query->where('fecha', $request->fecha);
        }

        if ($request->filled('cliente_id')) {
            $query->whereHas('clientes', fn($q) =>
            $q->where('clientes.id', $request->cliente_id));
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Agrega más filtros si deseas…

        return $query->orderBy('fecha', 'desc')->get();
    }





    public function create()
    {
        $clientes = \App\Models\Cliente::all();
        $personales = \App\Models\Personal::all();
        $servicios = \App\Models\Service::with('personal')->get();


        return view('agendas.create', compact('clientes', 'personales', 'servicios'));
    }



    public function store(Request $request)
    {
        // 🔴 PRIMERO: Validación personalizada - servicios requeridos
        if (!$request->has('servicios') || !is_array($request->servicios) || count($request->servicios) == 0) {
            return redirect()->back()
                ->withErrors(['general' => '⚠️ Debes agregar al menos un servicio antes de guardar.'])
                ->withInput();
        }

         // 🔴 SEGUNDO: Validar que no haya conflicto de disponibilidad antes de validate()
        $duracionPorServicio = [];
        foreach ($request->servicios as $service_id) {
            $duracion = \App\Models\Service::find($service_id)?->duration_minutes ?? $request->duracion;
            $personalId = $request->personal_por_servicio[$service_id] ?? null;

            if (!$personalId) continue;

            $disponible = $this->verificarDisponibilidad(
                $personalId,
                $request->fecha,
                $request->hora,
                $duracion
            );

            if (!$disponible) {
    $servicioObj = \App\Models\Service::find($service_id);
    $personalObj = \App\Models\Personal::find($personalId);

    $nombreServicio = $servicioObj?->name ?? 'Servicio';
    $nombrePersonal = $personalObj?->name ?? 'Personal';

    return redirect()->back()
        ->withErrors(['general' => "⚠️ El personal( $nombrePersonal ) ya tiene una cita para ( $nombreServicio ) ."])
        ->withInput();
}


            $duracionPorServicio[$service_id] = $duracion;
        }

        // ✅ TERCERO: Validación Laravel oficial
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'tipo_atencion' => 'required|in:salon,domicilio',
            'ubicacion' => 'nullable|string',
            'estado' => 'required|in:pendiente,confirmada,en_curso,finalizada,cancelada',
            'servicios' => 'required|array|min:1',
            'servicios.*' => 'exists:services,id',
            'personal_por_servicio' => 'required|array',
            'personal_por_servicio.*' => 'required|exists:personals,id',
            'cantidad_personas' => 'nullable|array',
            'cantidad_personas.*' => 'nullable|integer|min:1',
            'notas' => 'nullable|string|max:1000',
            'duracion' => 'required|integer|min:1',
            'precio_total' => 'required|numeric|min:0',
        ]);
 
        // 🔽 A partir de aquí ya es seguro crear
        DB::beginTransaction();
        try {
            $codigo = 'AG-' . strtoupper(uniqid());
            $request->merge(['codigo' => $codigo]);

            $agenda = Agenda::create($request->except('servicios', 'personal_por_servicio', 'cantidad_personas'));

            $agenda->clientes()->attach($request->cliente_id);

            foreach ($request->servicios as $service_id) {
                $personalId = $request->personal_por_servicio[$service_id];
                $cantidad = $request->cantidad_personas[$service_id] ?? 1;

                $agenda->servicios()->attach($service_id, [
                    'personal_id' => $personalId,
                    'cantidad' => $cantidad,
                ]);
            }

            $this->registrarEnBitacora('Crear agenda', $agenda->id);

            DB::commit();
            return redirect()->route('agendas.index')->with('success', 'Agenda creada exitosamente');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withErrors(['general' => 'Error: ' . $e->getMessage()])
                ->withInput();
        }
    }



 

    public function verificarDisponibilidad($personalId, $fecha, $hora, $duracionMinutos)
    {
        $horaInicio = Carbon::parse($hora);                        // ← solo parse
        $horaFin    = $horaInicio->copy()->addMinutes($duracionMinutos);

        $citas = DB::table('agenda_service')
            ->join('agendas',  'agenda_service.agenda_id',  '=', 'agendas.id')
            ->join('services', 'agenda_service.service_id', '=', 'services.id')
            ->where('agenda_service.personal_id', $personalId)
            ->where('agendas.fecha', $fecha)
            ->select('agendas.hora', 'services.duration_minutes')
            ->get();

        foreach ($citas as $cita) {
            $inicioExistente = Carbon::parse($cita->hora);         // ← solo parse
            $finExistente    = $inicioExistente->copy()->addMinutes($cita->duration_minutes);

            if (
                $horaInicio->between($inicioExistente, $finExistente) ||
                $horaFin->between($inicioExistente, $finExistente) ||
                $inicioExistente->between($horaInicio, $horaFin)
            ) {
                return false; // choque de horario
            }
        }

        return true; // disponible
    }




    public function edit(Agenda $agenda)
    {
        $agenda->load('servicios'); // Asegura que se cargue la relación
        $clientes = Cliente::all();
        $personals = Personal::all();
        $servicios = Service::all();

        return view('agendas.edit', compact('agenda', 'clientes', 'personals', 'servicios'));
    }




    public function update(Request $request, Agenda $agenda)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'personal_id' => 'required|exists:personals,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'tipo_atencion' => 'required|in:salon,domicilio',
            'ubicacion' => 'nullable|string',
            'notas' => 'nullable|string',
            'servicios' => 'required|array|min:1',
            'servicios.*' => 'exists:services,id',
            'duracion' => 'required|integer|min:1',
            'precio_total' => 'required|numeric|min:0',
        ]);

        // Actualiza los campos normales (excepto servicios)
        $agenda->update($request->except('servicios'));

        // Sincroniza los servicios relacionados
        $agenda->servicios()->sync($request->servicios);

        $this->registrarEnBitacora('Actualizar agenda', $agenda->id);

        return redirect()->route('agendas.index')->with('success', 'Agenda actualizada exitosamente');
    }


    public function destroy(Agenda $agenda)
    {
        $this->registrarEnBitacora('Eliminar agenda', $agenda->id);
        $agenda->delete();

        return redirect()->route('agendas.index')->with('success', 'Agenda eliminada');
    }
    
    public function misCitas()
    {
        $cliente_id = auth()->user()->cliente_id;

        $agendas = Agenda::whereHas('clientes', function ($q) use ($cliente_id) {
            $q->where('clientes.id', $cliente_id); // 👈 campo correcto
        })->with('servicios', 'personal')->get();

        return view('clientes.agenda.index', compact('agendas'));
    }
 
    public function show($id)
    {
        $agenda = Agenda::with(['clientes', 'personal', 'servicios'])->findOrFail($id);
        return view('agendas.show', compact('agenda'));
    }


    public function generarPDF($id)
    {
        $agenda = Agenda::with(['cliente', 'personal', 'servicios'])->findOrFail($id);

        return Pdf::loadView('pdf.cita', compact('agenda'))
            ->stream('cita-' . $agenda->id . '.pdf'); // O ->download(...) si prefieres
    }

    // AgendasController.php
    public function export(Request $request)
    {
        // Columnas predeterminadas a exportar
        $columns = $request->input('columns', ['id', 'fecha', 'hora', 'cliente_id', 'personal_id', 'tipo_atencion', 'ubicacion', 'estado']);

        // Obtener los datos de agendas con las relaciones necesarias
        $agendas = Agenda::with(['cliente', 'personal'])->select($columns)->orderBy('created_at', 'desc')->get();

        $query = Agenda::with(['cliente', 'personal'])->select($columns);

        // Aplicar el filtro de búsqueda si es necesario
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($query) use ($search) {
                $query->whereHas('cliente', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('personal', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }
        if ($request->filled('fecha')) {
            $query->where('fecha', $request->fecha);
        }

        $agendas = $query->orderBy('created_at', 'desc')->get();
        ///////
        // Si el formato es PDF
        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('agendas.pdf', compact('agendas', 'columns'));
            return $pdf->download('agendas.pdf');
        }

        // Si el formato es HTML
        if ($request->format === 'html') {
            return view('agendas.html', compact('agendas', 'columns'));
        }
        if ($request->format === 'csv') {
            return $this->exportCSV($agendas); // Asegúrate de tener este método creado
        }
        // Por defecto, exportar en HTML
        return view('agendas.html', compact('agendas', 'columns'));
    }

    public function searchAjax(Request $request)
    {
        $query = $request->get('query');

        $agendas = Agenda::with(['cliente', 'personal', 'servicios'])
            ->whereDate('fecha', 'like', "%{$query}%")
            ->orWhereHas('cliente', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->orWhereHas('personal', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->take(20)
            ->get();

        $html = '';
        foreach ($agendas as $agenda) {
            $servicios = $agenda->servicios->pluck('name')->implode(', ');
            $estado = $agenda->estado == 'confirmada' ? 'success' : 'secondary';
            $cliente = $agenda->cliente->name ?? '-';
            $personal = $agenda->personal->name ?? '-';

            $html .= '<tr>';
            $html .= "<td>{$agenda->id}</td>";
            $html .= "<td>{$agenda->fecha}</td>";
            $html .= "<td>{$agenda->hora}</td>";
            $html .= "<td>{$cliente}</td>";
            $html .= "<td>{$personal}</td>";
            $html .= "<td>{$servicios}</td>";
            $html .= "<td><span class='badge bg-{$estado}'>" . ucfirst($agenda->estado) . '</span></td>';
            $html .= "<td>{$agenda->ubicacion}</td>";
            $html .= '<td>';
            $html .= '<a href="' . route('agendas.show', $agenda->id) . '" class="btn btn-sm btn-outline-info">Ver</a> ';
            $html .= '<a href="' . route('agendas.edit', $agenda->id) . '" class="btn btn-sm btn-outline-warning">Editar</a> ';
            $html .= '<form action="' . route('agendas.destroy', $agenda->id) . '" method="POST" style="display:inline;">' . csrf_field() . method_field('DELETE');
            $html .= '<button class="btn btn-sm btn-outline-danger" onclick="return confirm(\'¿Cancelar esta cita?\')">Cancelar</button>';
            $html .= '</form>';
            $html .= '</td>';
            $html .= '</tr>';
        }

        if ($agendas->isEmpty()) {
            $html = '<tr><td colspan="9" class="text-center">No hay resultados.</td></tr>';
        }

        return response($html);
    }



    public function exportCSV($agendas)
    {
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

    public function exportPDF(Request $request)
    {
        $agendas = Agenda::with(['cliente', 'personal', 'servicios'])->get();

        // Si hay columnas seleccionadas, úsalas; si no, define unas por defecto:
        $columnas = $request->input('columns', [
            'id',
            'fecha',
            'hora',
            'cliente_id',
            'personal_id',
            'estado',
            'ubicacion'
        ]);

        $html = view('pdf.agendas', compact('agendas', 'columnas'))->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="agendas.pdf"');
    }
}
