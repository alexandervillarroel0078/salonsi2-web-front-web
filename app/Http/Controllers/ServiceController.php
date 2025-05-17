<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\BitacoraTrait;
use App\Models\Clasificador;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ServicesExport;

class ServiceController extends Controller
{
    use BitacoraTrait;

    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('category', 'like', '%' . $request->search . '%');
        }
        $services = Service::all();

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
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'has_discount' => 'boolean',
            'has_available' => 'boolean',
            'tipo_atencion' => 'required|in:salon,domicilio',
            'specialist_id' => 'nullable|exists:users,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $validated['image_path'] = $path;
        }

        Service::create($validated);
        $this->registrarEnBitacora('Crear servicio');

        return redirect()->route('services.index')->with('message', 'Servicio creado con éxito');
    }

    public function edit(Service $service)
    {
        $specialists = User::all();
        $categorias = Service::select('category')->distinct()->pluck('category')->filter()->values(); // sin nulos y únicos
        return view('services.edit', compact('service', 'specialists', 'categorias'));
    }


    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'has_discount' => 'boolean',
            'has_available' => 'boolean',
            'tipo_atencion' => 'required|in:salon,domicilio',
            'specialist_id' => 'nullable|exists:users,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $validated['image_path'] = $path;
        }

        $service->update($validated);
        $this->registrarEnBitacora('Actualizar servicio', $service->id);

        return redirect()->route('services.index')->with('message', 'Servicio actualizado con éxito');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        $this->registrarEnBitacora('Eliminar servicio', $service->id);

        return redirect()->route('services.index')->with('message', 'Servicio eliminado con éxito');
    }

    // Para mostrar el detalle de un servicio (incluye imágenes si existen)
    public function show($id)
    {
        $service = Service::with('images')->findOrFail($id);
        return view('services.show', compact('service'));
    }

    // API - Devuelve lista de servicios (para Flutter o móvil)
    public function getList()
    {
        $services = Service::orderBy('updated_at', 'desc')->get();
        return response()->json([
            'services' => $services
        ]);
    }


    public function export(Request $request)
    {
        // Definir las columnas válidas en la base de datos
        $validColumns = ['id', 'name', 'price', 'discount_price', 'category'];

        // Obtener las columnas seleccionadas, si no se selecciona ninguna, asignar las predeterminadas
        $columns = $request->input('columns', ['id', 'name', 'price', 'discount_price']);

        // Validar las columnas seleccionadas, asegurándonos de que estén en las columnas válidas
        $columns = array_filter($columns, function ($column) use ($validColumns) {
            return in_array($column, $validColumns);
        });

        // Si no se seleccionaron columnas válidas, asignamos las predeterminadas
        if (empty($columns)) {
            $columns = ['id', 'name', 'price', 'discount_price'];
        }

        // Obtener los servicios con las columnas seleccionadas
        $query = Service::select($columns);

        // Aplicar los filtros si es necesario
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('category', 'like', '%' . $request->search . '%');
        }

        // Obtener los servicios
        $services = $query->orderBy('updated_at', 'desc')->get();

        // Si el formato es PDF
        if ($request->format === 'pdf') {
            // Pasa las columnas seleccionadas también a la vista PDF
            $pdf = Pdf::loadView('services.pdf', compact('services', 'columns'));
            return $pdf->download('services.pdf');
        }

        // Si el formato es HTML
        if ($request->format === 'html') {
            // Pasa las columnas seleccionadas también a la vista HTML
            return view('services.html', compact('services', 'columns'));
        }

        // Si no se especifica el formato, retorna HTML por defecto
        return view('services.html', compact('services', 'columns'));
    }

    public function searchAjax(Request $request)
    {
        $query = $request->get('query');

        $services = Service::where('name', 'like', "%{$query}%")
            ->orWhere('category', 'like', "%{$query}%")
            ->take(20)
            ->get();

        $html = '';
        foreach ($services as $service) {
            $html .= '<tr>';
            $html .= '<td>' . $service->id . '</td>';
            $html .= '<td><img src="' . $service->image_path . '" width="60" height="60" style="object-fit:cover;"></td>';
            $html .= '<td>' . $service->name . '</td>';
            $html .= '<td>Bs ' . number_format($service->price, 2) . '</td>';
            $html .= '<td>' . ($service->has_discount ? 'Bs ' . number_format($service->discount_price, 2) : 'No') . '</td>';
            $html .= '<td><span class="badge bg-' . ($service->has_available ? 'success' : 'secondary') . '">' . ($service->has_available ? 'Disponible' : 'No disponible') . '</span></td>';
            $html .= '<td>' . ($service->category ?? 'Sin categoría') . '</td>';
            $html .= '<td>' . ucfirst($service->tipo_atencion) . '</td>';
            $html .= '<td>' . $service->duration_minutes . ' min</td>';
            $html .= '<td>
                    <a href="' . route('services.show', $service->id) . '" class="btn btn-sm btn-info">Ver</a>
                    <a href="' . route('services.edit', $service->id) . '" class="btn btn-sm btn-warning">Editar</a>
                    <form action="' . route('services.destroy', $service->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="btn btn-sm btn-danger" onclick="return confirm(\'¿Eliminar este servicio?\')">Eliminar</button>
                    </form>
                  </td>';
            $html .= '</tr>';
        }

        if ($services->isEmpty()) {
            $html = '<tr><td colspan="10" class="text-center">No hay resultados.</td></tr>';
        }

        return response($html);
    }
}
