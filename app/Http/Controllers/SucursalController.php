<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use App\Models\Producto;
use App\Models\MovimientoInventario;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::all();
        return view('sucursales.index', compact('sucursales'));
    }

    public function create()
    {
        return view('sucursales.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|max:255',
            'direccion' => 'nullable|max:255',
            'telefono' => 'nullable|max:20',
        ]);
        Sucursal::create($validated);
        return redirect()->route('sucursales.index')->with('success', 'Sucursal creada correctamente.');
    }

    public function show(Sucursal $sucursal)
    {
        return view('sucursales.show', compact('sucursal'));
    }

    public function edit(Sucursal $sucursal)
    {
        return view('sucursales.edit', compact('sucursal'));
    }

    public function update(Request $request, Sucursal $sucursal)
    {
        $validated = $request->validate([
            'nombre' => 'required|max:255',
            'direccion' => 'nullable|max:255',
            'telefono' => 'nullable|max:20',
        ]);
        $sucursal->update($validated);
        return redirect()->route('sucursales.index')->with('success', 'Sucursal actualizada correctamente.');
    }

    public function destroy(Sucursal $sucursal)
    {
        $sucursal->delete();
        return redirect()->route('sucursales.index')->with('success', 'Sucursal eliminada correctamente.');
    }
}