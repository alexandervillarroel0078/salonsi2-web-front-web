<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    return $this->hasMany(Agenda::class, 'cliente_id');
}
public function user()
{
    return $this->belongsTo(User::class);
}

}
