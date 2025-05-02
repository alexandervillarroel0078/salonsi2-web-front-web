<?php
namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Cliente;
use App\Models\Service;
use App\Models\Personal;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index() {
        $agendas = Agenda::with(['cliente', 'servicio', 'personal'])->latest()->paginate(10);
        return view('agendas.index', compact('agendas'));
    }

    public function create() {
        $clientes = Cliente::all();
        $servicios = Service::all();
        $personals = Personal::all();
        return view('agendas.create', compact('clientes', 'servicios', 'personals'));
    }

    public function store(Request $request) {
        $request->validate([
            'cliente_id' => 'required',
            'service_id' => 'required',
            'fecha' => 'required|date',
            'hora' => 'required',
            'tipo_atencion' => 'required',
        ]);

        Agenda::create($request->all());
        return redirect()->route('agendas.index')->with('success', 'Agenda creada exitosamente');
    }

    public function edit(Agenda $agenda) {
        $clientes = Cliente::all();
        $servicios = Service::all();
        $personals = Personal::all();
        return view('agendas.edit', compact('agenda', 'clientes', 'servicios', 'personals'));
    }

    public function update(Request $request, Agenda $agenda) {
        $agenda->update($request->all());
        return redirect()->route('agendas.index')->with('success', 'Agenda actualizada exitosamente');
    }

    public function destroy(Agenda $agenda) {
        $agenda->delete();
        return redirect()->route('agendas.index')->with('success', 'Agenda eliminada');
    }
}