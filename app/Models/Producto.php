<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'categoria',
        'tipo',
        'stock',
        'stock_minimo',
        'unidad',
        'descripcion',
        'sucursal_id',
    ];
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
    public function servicios()
    {
        return $this->belongsToMany(Service::class, 'producto_service', 'producto_id', 'service_id');
    }
}
