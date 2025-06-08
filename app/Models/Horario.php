<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'personal_id',   // FK hacia la tabla personals
        'day_name',      // Nombre del día (lunes, martes, etc.)
        'date',          // Fecha específica (opcional si usas semanal)
        'start_time',    // Hora de inicio
        'end_time',      // Hora de fin
        'available',     // Booleano: si está disponible o no
    ];

 
    public function personal(): BelongsTo
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
}
