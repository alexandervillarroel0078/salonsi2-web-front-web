<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;
use Barryvdh\DomPDF\Facade\Pdf;

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

    // app/Http/Controllers/ClienteController.php

    public function create()
    {
        return view('clientes.create');
    }




    //para flutter
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        return response()->json($cliente);
    }

    public function export(Request $request)
    {
        // Obtener las columnas seleccionadas
        $columns = $request->input('columns', ['id', 'name', 'email']);

        // Obtener los datos de clientes con las columnas seleccionadas
        $query = Cliente::select($columns);

        // Aplicar los filtros si es necesario
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        // Obtener los datos
        $clientes = $query->orderBy('created_at', 'desc')->get();

        // Si el formato es PDF
        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('clientes.pdf', compact('clientes', 'columns'));
            return $pdf->download('clientes.pdf');
        }

        // Si el formato es HTML
        if ($request->format === 'html') {
            return view('clientes.html', compact('clientes', 'columns'));
        }

        // Si no se especifica el formato, retorna HTML por defecto
        return view('clientes.html', compact('clientes', 'columns'));
    }


   public function searchAjax(Request $request)
{
    $query = $request->get('query');

    $clientes = Cliente::where('name', 'like', "%{$query}%")
        ->orWhere('email', 'like', "%{$query}%")
        ->orWhere('phone', 'like', "%{$query}%")
        ->withCount('agendas')
        ->take(20)
        ->get();

    $html = '';

    foreach ($clientes as $cliente) {
        $img = $cliente->photo ? asset('storage/' . $cliente->photo) : asset('images/default-profile.png');

        $html .= '<tr>';
        $html .= '<td>' . $cliente->id . '</td>';
        $html .= '<td>';
        $html .= '<img src="' . $img . '" class="rounded-circle" style="width: 50px; height: 50px;">';
        $html .= '</td>';
        $html .= '<td>' . $cliente->name . '</td>';
        $html .= '<td>' . $cliente->email . '</td>';
        $html .= '<td>' . $cliente->phone . '</td>';
        $html .= '<td>' . ($cliente->agendas_count ?? 0) . '</td>';

        $estado = $cliente->status ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>';
        $html .= '<td>' . $estado . '</td>';

        $html .= '<td>';
        $html .= '<a href="' . route('clientes.edit', $cliente->id) . '" class="btn btn-sm btn-warning">Editar</a>';
        $html .= '<form action="' . route('clientes.destroy', $cliente->id) . '" method="POST" style="display:inline;">';
        $html .= csrf_field();
        $html .= method_field('DELETE');
        $html .= '<button class="btn btn-sm btn-danger" onclick="return confirm(\'¿Eliminar este cliente?\')">Eliminar</button>';
        $html .= '</form>';
        $html .= '</td>';

        $html .= '</tr>';
    }

    if ($clientes->isEmpty()) {
        $html = '<tr><td colspan="8" class="text-center">No hay resultados.</td></tr>';
    }

  //  return response()->json(['html' => $html]);
return response($html);

}

}
