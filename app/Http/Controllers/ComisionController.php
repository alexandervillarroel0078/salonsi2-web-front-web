<?php

namespace App\Http\Controllers;

use App\Models\Comision;
use App\Models\CategoriaGasto;
use App\Models\Gasto;
use Illuminate\Support\Facades\Auth;
use App\Models\Agenda;
use App\Models\Service;
use App\Models\Personal;
use Illuminate\Http\Request;

class ComisionController extends Controller
{
    public function index()
    {
        $comisiones = Comision::with(['agenda', 'servicio', 'personal'])->get();
        return view('comisiones.index', compact('comisiones'));
    }

    public function pagar(Comision $comision)
    {
        if ($comision->estado !== 'pendiente') {
            return redirect()->back()->with('error', 'Esta comisión ya fue pagada.');
        }

        // 1. Actualizar la comisión
        $comision->update([
            'estado' => 'pagado',
            'fecha_pago' => now(),
            'metodo_pago' => 'transferencia',
        ]);

        // 2. Buscar categoría "Pago de comisiones"
        $categoria = CategoriaGasto::where('nombre', 'Pago de comisiones')->first();

        // 3. Registrar el gasto
        Gasto::create([
            'detalle' => 'Pago de comisión a ' . $comision->personal->name . ' por el servicio ' . $comision->servicio->name,
            'monto' => $comision->monto,
            'fecha' => now(),
            'categoria_gasto_id' => $categoria->id ?? null,
            'user_id' => Auth::id(),
            'agenda_id' => $comision->agenda_id,
        ]);

        return redirect()->route('comisiones.index')->with('success', 'Comisión pagada y gasto registrado correctamente.');
    }

    public function misComisiones()
    {
        $personal_id = auth()->user()->personal_id;

        $comisiones = \App\Models\Comision::with('servicio', 'agenda')
            ->where('personal_id', $personal_id)
            ->orderBy('fecha_pago', 'desc')
            ->get();

        return view('comisiones.mis', compact('comisiones'));
    }
}
