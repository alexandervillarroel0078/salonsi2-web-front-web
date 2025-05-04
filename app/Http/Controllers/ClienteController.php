<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;

class ClienteController extends Controller
{
    use BitacoraTrait;

    public function index(Request $request)
    {
        $query = Cliente::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $clientes = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('clientes.index', compact('clientes'));
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes',
            'phone' => 'nullable|string',
            'status' => 'boolean',
        ]);

        // Crear un nuevo cliente
        $cliente = Cliente::create($validated);
        $this->registrarEnBitacora('Crear cliente', $cliente->id);

        // Redirigir con mensaje de éxito
        return redirect()->route('clientes.index')->with('message', 'Cliente creado con éxito');
    }


    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string',
            'status' => 'boolean',
        ]);

        // Actualizamos los datos del cliente
        $cliente->update($validated);
        $this->registrarEnBitacora('Actualizar cliente', $cliente->id);

        return redirect()->route('clientes.index')->with('message', 'Cliente actualizado con éxito');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        $this->registrarEnBitacora('Eliminar cliente', $cliente->id);

        return redirect()->route('clientes.index')->with('message', 'Cliente eliminado con éxito');
    }
}
