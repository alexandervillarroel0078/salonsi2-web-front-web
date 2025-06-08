<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'image_path',
        'price',
        'discount_price',
        'duration_minutes',
        'has_discount',
        'has_available',
        'tipo_atencion',
    ];

    public function agendas()
    {
        return $this->belongsToMany(Agenda::class, 'agenda_service', 'service_id', 'agenda_id')
            ->withPivot('personal_id', 'cantidad')
            ->withTimestamps();
    }


    public function combos()
    {
        return $this->belongsToMany(Combo::class, 'combo_service', 'service_id', 'combo_id');
    }

    public function promociones()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_service', 'service_id', 'promotion_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_service', 'service_id', 'producto_id');
    }

    // Personal calificado para este servicio (relación estructural)
    public function personal()
    {
        return $this->belongsToMany(Personal::class, 'personal_service', 'service_id', 'personal_id');
    }

    // Personal que ha realizado este servicio en agendas (relación contextual)
    public function personalEnAgendas()
    {
        return $this->belongsToMany(Personal::class, 'agenda_service', 'service_id', 'personal_id');
    }
}
