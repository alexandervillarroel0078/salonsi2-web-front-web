<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\User;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $services = $query->orderBy('updated_at', 'desc')->paginate(10);

        return view('services.index', compact('services'));
    }

    public function create()
    {
        $specialists = User::all();
        return view('services.create', compact('specialists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'specialist_id' => 'nullable|numeric',
            'has_discount' => 'boolean',
            'has_available' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $validated['image_path'] = $path;
        }

        Service::create($validated);

        return redirect()->route('services.index')->with('message', 'Servicio creado con éxito');
    }

    public function edit(Service $service)
    {
        $specialists = User::all();
        return view('services.edit', compact('service', 'specialists'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'specialist_id' => 'nullable|numeric',
            'has_discount' => 'boolean',
            'has_available' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $validated['image_path'] = $path;
        }

        $service->update($validated);

        return redirect()->route('services.index')->with('message', 'Servicio actualizado con éxito');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')->with('message', 'Servicio eliminado con éxito');
    }

    public function getList()
    {
        $services = Service::orderBy('updated_at')->get();
        return response()->json([
            'services' => $services
        ]);
    }
}
