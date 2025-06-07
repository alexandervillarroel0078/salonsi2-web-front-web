<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CargoPersonal extends Model
{
    use HasFactory;

    protected $fillable = [
        'cargo',
        'estado'
    ];

    /**
     * Relación uno a muchos (1:N) con el modelo Personal.
     * Este cargo puede estar asignado a múltiples registros de personal.
     * La clave foránea 'cargo_personal_id' está en la tabla 'personals'.
     */
    public function personals(): HasMany
    {
        return $this->hasMany(Personal::class, 'cargo_personal_id');
    }
}
