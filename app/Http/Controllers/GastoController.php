<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use App\Models\CategoriaGasto;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GastoController extends Controller
{
    public function index()
    {
        $gastos = Gasto::with(['categoria', 'agenda'])->latest()->get();
        return view('gastos.index', compact('gastos'));
    }

    public function create()
    {
        $categorias = CategoriaGasto::where('activo', true)->get();
        $agendas = \App\Models\Agenda::all();

        return view('gastos.create', compact('categorias', 'agendas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'detalle' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'categoria_gasto_id' => 'required|exists:categorias_gasto,id',
        ]);

        Gasto::create([
            ...$request->all(),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('gastos.index')->with('success', 'Gasto registrado correctamente.');
    }

    public function edit($id)
    {
        $gasto = Gasto::findOrFail($id);
        $categorias = CategoriaGasto::where('activo', true)->get();
        $agendas = \App\Models\Agenda::all();

        return view('gastos.edit', compact('gasto', 'categorias', 'agendas'));
    }

    public function update(Request $request, $id)
    {
        $gasto = Gasto::findOrFail($id);
        $gasto->update($request->all());

        return redirect()->route('gastos.index')->with('success', 'Gasto actualizado correctamente.');
    }

    public function destroy($id)
    {
        Gasto::destroy($id);
        return back()->with('success', 'Gasto eliminado.');
    }
}
