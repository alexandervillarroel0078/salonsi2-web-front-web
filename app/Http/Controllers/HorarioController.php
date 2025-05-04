<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Personal;
use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;

class HorarioController extends Controller
{
    use BitacoraTrait;

    public function index(Request $request)
    {
        $query = Horario::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('date', 'like', '%' . $request->search . '%');
        }

        $horarios = $query->orderBy('date', 'desc')->paginate(10);

        return view('horarios.index', compact('horarios'));
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
}
