<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Personal;
use App\Models\Agenda;
use App\Models\Pago;

class ApiController extends Controller
{
    // Listar todos los servicios con relación al personal e imágenes (si tienes una relación images)
    public function listarServicios()
    {
        $servicios = Service::with(['personal'])->get(); // Cambiado de 'specialist' a 'personal'
        return response()->json(['services' => $servicios]);
    }

    // Listar todo el personal disponible
    public function listarPersonal()
    {
        $personal = Personal::all();
        return response()->json(['personal' => $personal]);
    }

    // Crear cita simple (Agenda)
    public function crearCita(Request $request)
    {
        $data = $request->validate([
            'cliente_id' => 'required|integer|exists:clientes,id',
            'personal_id' => 'required|integer|exists:personals,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'tipo_atencion' => 'nullable|string',
            'ubicacion' => 'nullable|string',
            'notas' => 'nullable|string',
            'duracion' => 'nullable|integer',
            'precio_total' => 'nullable|numeric',
            'servicios' => 'array|required',
            'servicios.*' => 'integer|exists:services,id'
        ]);

        $cita = Agenda::create($data);
        $cita->servicios()->sync($data['servicios']);

        return response()->json(['success' => true, 'cita' => $cita]);
    }

    // Registrar pago
    public function registrarPago(Request $request)
    {
        $data = $request->validate([
            'cita_id' => 'required|exists:agendas,id',
            'monto' => 'required|numeric',
            'estado' => 'nullable|string',
            'metodo_pago' => 'nullable|string',
        ]);

        $pago = Pago::create([
            'cita_id' => $data['cita_id'],
            'monto' => $data['monto'],
            'estado' => $data['estado'] ?? 'pagado',
            'metodo_pago' => $data['metodo_pago'] ?? 'simulado',
        ]);

        return response()->json(['success' => true, 'pago' => $pago]);
    }

    // Ver citas de un cliente
    public function verCitasCliente($cliente_id)
    {
        $citas = Agenda::with(['personal', 'servicios'])
            ->where('cliente_id', $cliente_id)
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'citas' => $citas
        ]);
    }
}
