<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'personal_id',
        'fecha',
        'estado',          // por ejemplo: presente, ausente, justificado
        'observaciones'
    ];

    /**
     * Relación muchos a uno (N:1) con el modelo Personal.
     * Esta asistencia pertenece a un solo personal.
     * La clave foránea 'personal_id' está en esta tabla.
     */
    public function personal(): BelongsTo
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
}
