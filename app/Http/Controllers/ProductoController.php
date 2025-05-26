<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Sucursal;
use Illuminate\Support\Facades\View;

class ProductoController extends Controller
{
    // Muestra listado con filtros y búsqueda
    public function index(Request $request)
    {
        $query = Producto::query();

        if ($request->search) {
            $query->where('nombre', 'like', '%' . $request->search . '%')
                ->orWhere('descripcion', 'like', '%' . $request->search . '%');
        }
        if ($request->categoria) {
            $query->where('categoria', $request->categoria);
        }
        if ($request->tipo) {
            $query->where('tipo', $request->tipo);
        }

        $productos = $query->orderBy('nombre')->paginate(15);

        // Exportar
        if ($request->format == 'pdf' || $request->format == 'html') {
            $view = View::make('productos.export', compact('productos'))->render();
            if ($request->format == 'pdf') {
                $pdf = \PDF::loadHTML($view);
                return $pdf->download('productos.pdf');
            }
            return response($view);
        }

        return view('productos.index', compact('productos'));
    }
    public function create()
    {
        $sucursales = Sucursal::all();
        return view('productos.create', compact('sucursales'));
    }

    // public function create()
    // {
    //     return view('productos.create');
    // }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:productos,nombre',
            'categoria' => 'nullable|string|max:100',
            'tipo' => 'required|in:consumible,equipo',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'unidad' => 'nullable|string|max:20',
            'descripcion' => 'nullable|string|max:500',
            'sucursal_id' => 'required|exists:sucursales,id',
        ]);
        Producto::create($validated);
        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }
    
    public function edit(Producto $producto)
    {
        $sucursales = Sucursal::all();
        return view('productos.edit', compact('producto', 'sucursales'));
    }

    // public function edit(Producto $producto)
    // {
    //     return view('productos.edit', compact('producto'));
    // }

    public function update(Request $request, Producto $producto)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255|unique:productos,nombre,' . $producto->id, // Ignora el mismo producto
        'categoria' => 'nullable|string|max:100',
        'tipo' => 'required|in:consumible,equipo',
        'stock' => 'required|integer|min:0',
        'stock_minimo' => 'nullable|integer|min:0',
        'unidad' => 'nullable|string|max:20',
        'descripcion' => 'nullable|string|max:500',
        'sucursal_id' => 'required|exists:sucursales,id',
    ]);
    $producto->update($validated);
    return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
}


    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }

    // Exportación manual (opcional si quieres ruta extra)
    public function export(Request $request)
    {
        $productos = Producto::all();
        $view = View::make('productos.export', compact('productos'))->render();

        if ($request->format == 'pdf') {
            $pdf = \PDF::loadHTML($view);
            return $pdf->download('productos.pdf');
        }
        return response($view);
    }
}
