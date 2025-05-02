<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Personal;
use Illuminate\Http\Request;

class AsistenciaController extends Controller {
    public function index() {
        $asistencias = Asistencia::with('personal')->orderBy('fecha', 'desc')->paginate(10);
        return view('asistencias.index', compact('asistencias'));
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
    
        Asistencia::create([
            'personal_id' => $request->personal_id,
            'fecha' => $request->fecha,
            'estado' => $request->estado,
            'observaciones' => $request->observaciones,
        ]);
    
        return redirect()->route('asistencias.index')->with('message', 'Asistencia registrada.');
    }
    
    

}