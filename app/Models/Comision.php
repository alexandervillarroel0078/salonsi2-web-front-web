<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Comision extends Model
{
    // Opcional si la tabla no sigue la convención plural inglesa
    protected $table = 'comisiones';

    /**
     * Campos que se pueden asignar masivamente
     */
    protected $fillable = [
        'agenda_id',
        'service_id',
        'personal_id',
        'monto',
        'estado',        // pendiente | pagado
        'fecha_pago',
        'metodo_pago',
        'observaciones',
    ];

    /*--------------------------------------------------------------
    | RELACIONES
    --------------------------------------------------------------*/
    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function servicio()          // singular, pero apunta a Service
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }

    /*--------------------------------------------------------------
    | SCOPES ÚTILES
    --------------------------------------------------------------*/
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopePagadas($query)
    {
        return $query->where('estado', 'pagado');
    }

    /*--------------------------------------------------------------
    | ACCESORES / MUTADORES
    --------------------------------------------------------------*/
    protected function estado(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value),   // Normaliza
        );
    }
}
