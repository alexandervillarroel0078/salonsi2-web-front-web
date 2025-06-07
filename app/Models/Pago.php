<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'monto',
        'estado',
        'metodo_pago',
        'agenda_id',
        'cliente_id',
    ];

    public function agenda(): BelongsTo
    {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
