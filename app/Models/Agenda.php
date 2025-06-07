<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'fecha',
        'hora',
        'tipo_atencion',
        'ubicacion',
        'estado',
        'notas',
        'duracion',
        'precio_total'
    ];

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'agenda_cliente', 'agenda_id', 'cliente_id');
    }

 

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'agenda_id');
    }

    public function servicios()
    {
        return $this->belongsToMany(Service::class, 'agenda_service', 'agenda_id', 'service_id');
    }

    public function personal()
    {
        return $this->belongsToMany(Personal::class, 'agenda_service', 'agenda_id', 'personal_id');
    }
}
