<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Personal;
use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;
use Maatwebsite\Excel\Facades\Excel;

class HorarioController extends Controller
{
    use BitacoraTrait;

    public function index(Request $request)
    {
        $query = Horario::with('personal');

        // Filtro por fecha
        if ($request->filled('fecha')) {
            $query->where('date', $request->fecha);
        }

        // Filtro por personal
        if ($request->filled('personal_id')) {
            $query->where('personal_id', $request->personal_id);
        }

        // Filtro por disponibilidad
        if ($request->filled('disponible')) {
            $query->where('available', $request->disponible);
        }

        // Filtro de búsqueda general (si lo usas aparte)
        if ($request->filled('search')) {
            $query->where('date', 'like', '%' . $request->search . '%');
        }

        $horarios = $query->orderBy('date', 'desc')->paginate(10);

        // Pasa la lista de personal también para los filtros
        $personals = \App\Models\Personal::all();

        return view('horarios.index', compact('horarios', 'personals'));
    }



    public function create()
    {
        $personals = Personal::all();
        return view('horarios.create', compact('personals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'personal_id' => 'required|exists:personals,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'available' => 'boolean',
        ]);

        Horario::create($validated);
        $this->registrarEnBitacora('Crear horario');

        return redirect()->route('horarios.index')->with('message', 'Horario creado con éxito');
    }

    public function edit(Horario $horario)
    {
        $personals = Personal::all();
        return view('horarios.edit', compact('horario', 'personals'));
    }

    public function update(Request $request, Horario $horario)
    {
        $validated = $request->validate([
            'personal_id' => 'required|exists:personals,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'available' => 'boolean',
        ]);

        $horario->update($validated);
        $this->registrarEnBitacora('Actualizar horario', $horario->id);

        return redirect()->route('horarios.index')->with('message', 'Horario actualizado con éxito');
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();
        $this->registrarEnBitacora('Eliminar horario', $horario->id);

        return redirect()->route('horarios.index')->with('message', 'Horario eliminado con éxito');
    }

    public function export(Request $request)
    {
        $query = Horario::with('personal');

        if ($request->filled('fecha')) {
            $query->where('date', $request->fecha);
        }

        if ($request->filled('personal_id')) {
            $query->where('personal_id', $request->personal_id);
        }

        if ($request->filled('disponible')) {
            $query->where('available', $request->disponible);
        }

        $horarios = $query->get();

        return view('horarios.plantilla_html', compact('horarios')); // Solo HTML, sin DomPDF
    }
}
