<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'cita_id',
        'monto',
        'estado',
        'metodo_pago',
    ];

    // Relación con la cita (Agenda)
    public function cita()
    {
        return $this->belongsTo(Agenda::class, 'cita_id');
    }
}
