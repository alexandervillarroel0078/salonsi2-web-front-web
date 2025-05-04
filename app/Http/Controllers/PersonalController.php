<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;

class PersonalController extends Controller
{
    use BitacoraTrait;

    // Mostrar todos los empleados con paginación y búsqueda
    public function index(Request $request)
    {
        $query = Personal::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $personals = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('personals.index', compact('personals'));
    }

    // Mostrar formulario para crear un nuevo personal
    public function create()
    {
        return view('personals.create');
    }

    // Almacenar un nuevo personal
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:personals',
            'phone' => 'nullable|string|max:255',
            'status' => 'boolean',
            'photo_url' => 'nullable|url',
        ]);

        Personal::create($validated);
        $this->registrarEnBitacora('Crear personal');

        return redirect()->route('personals.index')->with('message', 'Personal creado con éxito');
    }

    // Mostrar formulario para editar un personal
    public function edit(Personal $personal)
    {
        return view('personals.edit', compact('personal'));
    }

    // Actualizar un personal existente
    public function update(Request $request, Personal $personal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:personals,email,' . $personal->id,
            'phone' => 'nullable|string|max:255',
            'status' => 'boolean',
            'photo_url' => 'nullable|url',
        ]);

        $personal->update($validated);
        $this->registrarEnBitacora('Actualizar personal', $personal->id);

        return redirect()->route('personals.index')->with('message', 'Personal actualizado con éxito');
    }

    // Eliminar un personal
    public function destroy(Personal $personal)
    {
        $personal->delete();
        $this->registrarEnBitacora('Eliminar personal', $personal->id);

        return redirect()->route('personals.index')->with('message', 'Personal eliminado con éxito');
    }
    // API: Obtener todos los personales en formato JSON
    public function getList()
    {
        $personals = Personal::orderBy('created_at', 'desc')->get();

        return response()->json($personals);
    }
}
