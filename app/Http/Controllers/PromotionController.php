<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;

class PromotionController extends Controller
{
    use BitacoraTrait;

    public function index()
    {
        $promotions = Promotion::all();
        return view('promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('promotions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
$this->registrarEnBitacora('Crear promoción');

        Promotion::create($request->all());

        return redirect()->route('promotions.index')->with('message', 'Promoción creada con éxito');
    }

    public function edit(Promotion $promotion)
    {
        return view('promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $promotion->update($request->all());
        $this->registrarEnBitacora('Actualizar promoción', $promotion->id);

        return redirect()->route('promotions.index')->with('message', 'Promoción actualizada con éxito');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        $this->registrarEnBitacora('Eliminar promoción', $promotion->id);

        return redirect()->route('promotions.index')->with('message', 'Promoción eliminada con éxito');
    }
    public function getList()
    {
        $promotions = Promotion::orderBy('updated_at', 'desc')->get();
        return response()->json($promotions);
    }
}
