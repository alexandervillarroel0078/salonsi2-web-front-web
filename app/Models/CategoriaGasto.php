<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaGasto extends Model
{
    use HasFactory;

    protected $table = 'categorias_gasto';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    public function gastos()
    {
        return $this->hasMany(Gasto::class, 'categoria_gasto_id');
    }
}
