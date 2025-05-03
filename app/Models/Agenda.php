<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'service_id',
        'personal_id',
        'fecha',
        'hora',
        'tipo_atencion',
        'estado',
        'notas'
    ];

    public function cliente() {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    

    public function servicio() {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function personal() {
        return $this->belongsTo(Personal::class);
    }
}