<?php

namespace App\Http\Controllers;

use App\Models\CategoriaGasto;
use Illuminate\Http\Request;

class CategoriaGastoController extends Controller
{
    public function index()
    {
        $categorias = CategoriaGasto::all();
        return view('categorias_gasto.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias_gasto.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        CategoriaGasto::create($request->all());

        return redirect()->route('categorias-gasto.index')->with('success', 'Categoría creada correctamente.');
    }

    public function edit($id)
    {
        $categoria = CategoriaGasto::findOrFail($id);
        return view('categorias_gasto.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $categoria = CategoriaGasto::findOrFail($id);
        $categoria->update($request->all());

        return redirect()->route('categorias-gasto.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy($id)
    {
        CategoriaGasto::destroy($id);
        return back()->with('success', 'Categoría eliminada.');
    }
}
