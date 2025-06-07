<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo_url',
        'status',
    ];


    public function agendas()
    {
        return $this->belongsToMany(Agenda::class, 'agenda_cliente', 'cliente_id', 'agenda_id');
    }

public function pagos()
    {
        return $this->hasMany(Pago::class, 'cliente_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'cliente_id');
    }
}
