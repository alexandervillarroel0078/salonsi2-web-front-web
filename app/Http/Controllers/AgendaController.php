<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Cliente;
use App\Models\Service;
use App\Models\Personal;
use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;
use Barryvdh\DomPDF\Facade\Pdf;

class AgendaController extends Controller
{
    use BitacoraTrait;

    public function index(Request $request)
    {
        $query = Agenda::with(['cliente', 'personal', 'servicios']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('cliente', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                })->orWhereHas('personal', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%$search%");
                });
            });
        }
        if ($request->filled('fecha')) {
            $query->where('fecha', $request->fecha);
        }
        $agendas = $query->orderBy('fecha', 'desc')->get();

        return view('agendas.index', compact('agendas'));
    }

    public function create()
    {
        $clientes = \App\Models\Cliente::all();      // 👈 Importante
        $personales = \App\Models\Personal::all();
        $servicios = \App\Models\Service::all();

        return view('agendas.create', compact('clientes', 'personales', 'servicios'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'personal_id' => 'required|exists:personals,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'tipo_atencion' => 'required|in:salon,domicilio',
            'ubicacion' => 'nullable|string',
            'estado' => 'required|in:pendiente,confirmada,en_curso,finalizada,cancelada',
            'servicios' => 'required|array',
            'servicios.*' => 'exists:services,id',
            'duracion' => 'required|integer|min:1',
            'precio_total' => 'required|numeric|min:0',
        ]);

        $agenda = Agenda::create($request->except('servicios'));

        // Asignar servicios seleccionados
        $agenda->servicios()->attach($request->servicios);

        $this->registrarEnBitacora('Crear agenda', $agenda->id);

        return redirect()->route('agendas.index')->with('success', 'Agenda creada exitosamente');
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



    public function show(Agenda $agenda)
    {
        $agenda->load(['cliente', 'personal', 'servicios']);
        return view('agendas.show', compact('agenda'));
    }


    public function generarPDF($id)
    {
        $agenda = Agenda::with(['cliente', 'personal', 'servicios'])->findOrFail($id);

        return Pdf::loadView('pdf.cita', compact('agenda'))
            ->stream('cita-' . $agenda->id . '.pdf'); // O ->download(...) si prefieres
    }
    //fluter 
    public function getCitasPorCliente($id)
    {
        $citas = Agenda::where('cliente_id', $id)
            ->with(['personal', 'servicios']) // relaciones si las tienes
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json($citas);
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
}
