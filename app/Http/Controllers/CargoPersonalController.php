<?php

namespace App\Http\Controllers;

use App\Models\CargoPersonal;
use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;

class CargoPersonalController extends Controller
{
    use BitacoraTrait;

    public function index()
    {
        $cargos = CargoPersonal::all();
        return view('cargo_personals.index', compact('cargos'));
    }

    public function create()
    {
        return view('cargo_personals.create');
    }

    public function store(Request $request)
    {
        $request->validate(['cargo' => 'required|string|max:255']);
        $cargo = CargoPersonal::create(['cargo' => $request->cargo]);
        $this->registrarEnBitacora('Crear cargo', $cargo->id);
        return redirect()->route('cargos.index')->with('success', 'Cargo creado correctamente.');
    }

    public function edit($id)
    {
        $cargo = CargoPersonal::findOrFail($id);
        return view('cargo_personals.edit', compact('cargo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['cargo' => 'required|string|max:255']);
        $cargo = CargoPersonal::findOrFail($id);
        $cargo->update(['cargo' => $request->cargo]);
        return redirect()->route('cargos.index')->with('success', 'Cargo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $cargo = CargoPersonal::findOrFail($id);
        $cargo->delete();
        $this->registrarEnBitacora('Eliminar cargo', $cargo->id);
        return redirect()->route('cargos.index')->with('success', 'Cargo eliminado correctamente.');
    }
}
