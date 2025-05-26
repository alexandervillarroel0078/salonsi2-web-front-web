<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $fillable = [
        'producto_id', 'tipo', 'cantidad', 'motivo', 'observaciones', 'user_id'
    ];

    public function producto() {
        return $this->belongsTo(Producto::class, 'producto_id');
    }  

    public function usuario() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
