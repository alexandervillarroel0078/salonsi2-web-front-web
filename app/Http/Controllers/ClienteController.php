<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Agenda;

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

    public function verMisCitasParaConfirmar($id)
    {
        $agenda = Agenda::with(['servicios'])->findOrFail($id);

        if ($agenda->estado !== 'por_confirmar') {
            abort(403, 'Esta agenda no requiere confirmación.');
        }

        // Cargar el modelo Personal manualmente desde el pivot
        foreach ($agenda->servicios as $servicio) {
            $servicio->pivot->personal = \App\Models\Personal::find($servicio->pivot->personal_id);
        }

        return view('clientes.agenda.show', compact('agenda'));
    }
    public function confirmarYCalificar(Request $request, $id)
    {
        $agenda = Agenda::with('servicios')->findOrFail($id);

        if ($agenda->estado !== 'por_confirmar') {
            abort(403, 'Esta agenda no puede ser confirmada.');
        }

        // Validación
        $request->validate([
            'valoraciones'   => 'required|array',
            'comentarios'    => 'nullable|array',
            'valoraciones.*' => 'required|integer|min:1|max:5',   // ← pon nullable si no es obligatoria
            'comentarios.*'  => 'nullable|string|max:500',
        ]);

        // Guardar calificaciones del cliente a cada servicio
        foreach ($agenda->servicios as $servicio) {
            $agenda->servicios()->updateExistingPivot($servicio->id, [
                'valoracion_cliente'  => $request->valoraciones[$servicio->id]      ?? null,
                'comentario_cliente'  => $request->comentarios[$servicio->id]       ?? null,
            ]);
        }

        // Marcar agenda como finalizada
        $agenda->update(['estado' => 'finalizada']);

        // (Opcional) Registrar comisiones y gastos
        // $this->registrarComisiones($agenda);

        return redirect()->route('clientes.agenda.index')
            ->with('success', '✅ Has confirmado y calificado los servicios correctamente.');
    }
}
