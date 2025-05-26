<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\MovimientoInventario;
use App\Models\Sucursal;

class InventarioController extends Controller
{
    // Muestra la lista de productos (de todas las sucursales)
    public function index() {
        $productos = Producto::with('sucursal')->get();
        return view('inventario.index', compact('productos'));
    }

    // Muestra el formulario para crear un movimiento (entrada/salida)
    public function create() {
        $productos = Producto::with('sucursal')->get();
        return view('inventario.create', compact('productos'));
    }

    public function registrarMovimiento(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string',
            'observaciones' => 'nullable|string'
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        // Verifica si hay stock suficiente para salida
        if ($request->tipo == 'salida' && $producto->stock < $request->cantidad) {
            return back()->with('error', 'No hay suficiente stock para realizar la salida.');
        }

        // Actualiza stock
        if ($request->tipo == 'entrada') {
            $producto->stock += $request->cantidad;
        } else {
            $producto->stock -= $request->cantidad;
            if ($producto->stock < 0) {
                $producto->stock = 0; // Protección extra
            }
        }
        $producto->save();

        // Registra el movimiento
        MovimientoInventario::create([
            'producto_id' => $request->producto_id,
            'tipo' => $request->tipo,
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
            'observaciones' => $request->observaciones,
            'user_id' => auth()->id()
        ]);

        return back()->with('success', 'Movimiento registrado y stock actualizado correctamente.');
    }

    // Muestra el historial de movimientos de inventario
    public function movimientos() {
        $movimientos = MovimientoInventario::with('producto', 'usuario')->latest()->paginate(15);
        return view('inventario.movimientos', compact('movimientos'));
    }

    // Muestra productos SOLO de una sucursal específica
    public function porSucursal($sucursalId) {
        $sucursal = Sucursal::findOrFail($sucursalId);
        $productos = Producto::where('sucursal_id', $sucursal->id)->get();
        return view('inventario.index', compact('productos', 'sucursal'));
    }
}
