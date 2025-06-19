<?php

namespace App\Http\Controllers;

use App\Models\Comision;
use App\Models\Agenda;
use App\Models\Service;
use App\Models\Personal;
use Illuminate\Http\Request;

class ComisionController extends Controller
{
    public function index()
    {
        $comisiones = Comision::with(['agenda', 'servicio', 'personal'])->get();
        return view('comisiones.index', compact('comisiones'));
    }

    public function create()
    {
        $agendas = Agenda::all();
        $servicios = Service::all();
        $personales = Personal::all();
        return view('comisiones.create', compact('agendas', 'servicios', 'personales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'agenda_id' => 'required|exists:agendas,id',
            'service_id' => 'required|exists:services,id',
            'personal_id' => 'required|exists:personals,id',
            'monto' => 'required|numeric',
            'estado' => 'required|in:pendiente,pagado',
        ]);

        Comision::create($request->all());

        return redirect()->route('comisiones.index')->with('success', 'Comisión registrada correctamente.');
    }

    public function edit(Comision $comision)
    {
        $agendas = Agenda::all();
        $servicios = Service::all();
        $personales = Personal::all();
        return view('comisiones.edit', compact('comision', 'agendas', 'servicios', 'personales'));
    }

    public function update(Request $request, Comision $comision)
    {
        $request->validate([
            'monto' => 'required|numeric',
            'estado' => 'required|in:pendiente,pagado',
        ]);

        $comision->update($request->all());

        return redirect()->route('comisiones.index')->with('success', 'Comisión actualizada.');
    }

    public function destroy(Comision $comision)
    {
        $comision->delete();
        return redirect()->route('comisiones.index')->with('success', 'Comisión eliminada.');
    }
}
