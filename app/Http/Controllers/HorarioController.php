<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Personal;
use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class HorarioController extends Controller
{
    use BitacoraTrait;

    public function index(Request $request)
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

        if ($request->filled('search')) {
            $query->where('date', 'like', '%' . $request->search . '%');
        }

        $horarios = $query->orderBy('date', 'asc')->paginate(10);
        $personals = Personal::all();

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
            'horarios' => 'required|array'
        ]);

        $personalId = $request->personal_id;
        $horarios = $request->horarios;

        foreach ($horarios as $dia => $datos) {
            if (isset($datos['disponible']) && $datos['disponible'] == 1 && $datos['inicio'] && $datos['fin']) {
                Horario::create([
                    'personal_id' => $personalId,
                    'day_name'    => ucfirst($dia), // <-- ¡Este campo es obligatorio!
                    'date'        => now()->startOfWeek()->addDays($this->diaNumero($dia))->format('Y-m-d'),
                    'start_time'  => $datos['inicio'],
                    'end_time'    => $datos['fin'],
                    'available'   => true,
                ]);
            }
        }


        $this->registrarEnBitacora('Crear horario semanal');

        return redirect()->route('horarios.index')->with('message', 'Horario semanal creado con éxito');
    }

    public function edit($personal_id)
    {
        $personal = Personal::findOrFail($personal_id);

        return view('horarios.edit', [
            'personal' => $personal,
            'horarios' => $personal->horarios, // usa la relación directamente
        ]);
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

    public function show($id)
    {
        $horario = Horario::with('personal')->findOrFail($id);
        $horarios = Horario::where('personal_id', $horario->personal_id)->orderBy('date')->get();

        return view('horarios.show', compact('horario', 'horarios'));
    }


    private function diaNumero($dia)
    {
        $dias = [
            'lunes' => 0,
            'martes' => 1,
            'miércoles' => 2,
            'miercoles' => 2,
            'jueves' => 3,
            'viernes' => 4,
            'sábado' => 5,
            'sabado' => 5,
            'domingo' => 6
        ];

        return $dias[strtolower($dia)] ?? 0;
    }



    // para pdf 
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

        if ($request->filled('search')) {
            $query->where('date', 'like', '%' . $request->search . '%');
        }

        $horarios = $query->orderBy('date', 'asc')->get();

        // Si es PDF
        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('horarios.pdf', compact('horarios'));
            return $pdf->download('horarios.pdf');
        }
        if ($request->format === 'html') {
            return view('horarios.html', compact('horarios'));
        }

        // Si es HTML
        return view('horarios.pdf', compact('horarios'));
    }
}
