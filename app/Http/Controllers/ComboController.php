<?php
namespace App\Http\Controllers;

use App\Models\Combo;
use App\Models\Service;
use Illuminate\Http\Request;

class ComboController extends Controller
{
    public function index()
    {
        $combos = Combo::with('services')->get();  // Cargamos los combos junto con sus servicios
        return view('combos.index', compact('combos'));
    }

    public function create()
    {
        $services = Service::all();  // Obtenemos todos los servicios disponibles para añadir al combo
        return view('combos.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'has_discount' => 'boolean',
        ]);

        $combo = Combo::create([
            'name' => $request->name,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'has_discount' => $request->has_discount,
        ]);

        // Asignar los servicios seleccionados al combo
        $combo->services()->attach($request->services);

        return redirect()->route('combos.index')->with('message', 'Combo creado con éxito');
    }

    public function edit(Combo $combo)
    {
        $services = Service::all();  // Obtenemos todos los servicios disponibles
        return view('combos.edit', compact('combo', 'services'));
    }

    public function update(Request $request, Combo $combo)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'has_discount' => 'boolean',
        ]);

        $combo->update([
            'name' => $request->name,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'has_discount' => $request->has_discount,
        ]);

        // Actualizar los servicios del combo
        $combo->services()->sync($request->services);

        return redirect()->route('combos.index')->with('message', 'Combo actualizado con éxito');
    }
}
