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

        // Buscar por nombre o categoría
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('category', 'like', '%' . $request->search . '%');
            });
        }

        // Estado (activo, inactivo)
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Precio mínimo
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        // Precio máximo
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Solo con descuento
        if ($request->has('con_descuento')) {
            $query->whereNotNull('discount_price')->where('discount_price', '>', 0);
        }

        // Duración mínima
        if ($request->filled('min_duracion')) {
            $query->where('duration_minutes', '>=', $request->min_duracion);
        }

        // Duración máxima
        if ($request->filled('max_duracion')) {
            $query->where('duration_minutes', '<=', $request->max_duracion);
        }

        // Tipo de atención (salón, domicilio)
        if ($request->filled('tipo_atencion')) {
            $query->where('tipo_atencion', $request->tipo_atencion);
        }

        // Disponibilidad (has_available = true/false)
        if ($request->filled('disponibilidad')) {
            $query->where('has_available', $request->disponibilidad === 'disponible');
        }

        // Ordenar por
        switch ($request->ordenar) {
            case 'nombre_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'nombre_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'precio_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'fecha_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'fecha_desc':
                $query->orderBy('created_at', 'desc');
                break;
        }


        $services = $query->paginate(10)->appends($request->all());

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


    public function show($id)
    {
        $service = Service::with('images')->findOrFail($id);
        return view('services.show', compact('service'));
    }

    public function export(Request $request) {}

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
