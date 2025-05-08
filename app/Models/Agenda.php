<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Service;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
       // 'service_id',
        'personal_id',
        'fecha',
        'hora',
        'tipo_atencion',
        'ubicacion', 
        'estado',
        'notas',
        'duracion',
        'precio_total'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }


    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'agenda_service', 'agenda_id', 'service_id');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }
}
