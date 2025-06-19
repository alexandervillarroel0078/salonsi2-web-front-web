<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;

    protected $fillable = [
        'detalle',
        'monto',
        'fecha',
        'categoria_gasto_id',
        'user_id',
        'agenda_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaGasto::class, 'categoria_gasto_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }
}
 