<?php

namespace App\Traits;

use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait BitacoraTrait
{
    public function registrarEnBitacora($accion, $id_operacion = null)
    {
        try {
            $nombre = Auth::check() ? Auth::user()->name : 'Invitado';
            Log::info("Registrando acción en bitácora: $accion por $nombre");

            Log::channel('bitacora')->info('Acción realizada', [
                'usuario' => $nombre,
                'user_id' => Auth::id(),
                'ip' => request()->ip(),
                'accion' => $accion,
                'id_operacion' => $id_operacion,
                'fecha_hora' => now()->toDateTimeString(),
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al registrar en bitácora: ' . $e->getMessage());
        }
    }
}
