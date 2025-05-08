<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Personal;
use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;

class AsistenciaController extends Controller {

    use BitacoraTrait;


    public function index(Request $request)
{
    // Obtener todos los personales (para el select)
    $personals = Personal::all();

    // Construir la consulta base
    $query = Asistencia::with('personal');

    // Aplicar filtros si existen
    if ($request->filled('personal_id')) {
        $query->where('personal_id', $request->personal_id);
    }

    if ($request->filled('mes') && $request->filled('año')) {
        $query->whereMonth('fecha', $request->mes)
              ->whereYear('fecha', $request->año);
    }

    // Obtener resultados
    $asistencias = $query->get();

    // Agrupar por personal
    $asistenciasAgrupadas = $asistencias->groupBy('personal_id')->map(function ($asistenciasPorPersonal) {
        return $asistenciasPorPersonal->first()->personal;
    });

    return view('asistencias.index', compact('asistenciasAgrupadas', 'personals'));
}


    public function create() {
        $personals = \App\Models\Personal::all();
        return view('asistencias.create', compact('personals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'personal_id' => 'required|exists:personals,id',
            'fecha' => 'required|date',
            'estado' => 'required|in:presente_local,presente_domicilio,ausente',
            'observaciones' => 'nullable|string',
        ]);
    
        $asistencia = Asistencia::create([
            'personal_id' => $request->personal_id,
            'fecha' => $request->fecha,
            'estado' => $request->estado,
            'observaciones' => $request->observaciones,
        ]);
        
        $this->registrarEnBitacora('Registró una nueva asistencia', $asistencia->id);

        return redirect()->route('asistencias.index')->with('message', 'Asistencia registrada.');
    }
    // En AsistenciaController
public function show($id)
{
    return view('asistencias.show'); // Solo diseño, sin lógica aún
}

    

}