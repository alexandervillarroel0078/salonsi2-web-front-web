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
        $services = \App\Models\Service::where('has_available', true)->get();

        return view('promotions.create', compact('services'));
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
        $services = \App\Models\Service::where('has_available', true)->get();
        return view('promotions.edit', compact('promotion', 'services'));
    }



    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
        ]);

        $promotion->update([
            'name' => $request->name,
            'description' => $request->description,
            'discount_percentage' => $request->discount_percentage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'active' => $request->has('active'),
        ]);

        $promotion->services()->sync($request->services);

        return redirect()->route('promotions.index')->with('message', 'Promoción actualizada correctamente.');
    }


    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        $this->registrarEnBitacora('Eliminar promoción', $promotion->id);

        return redirect()->route('promotions.index')->with('message', 'Promoción eliminada con éxito');
    }

 

}
