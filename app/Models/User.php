<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'personal_id',
        'cliente_id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }


    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class);
    }
    public function gastos()
    {
        return $this->hasMany(Gasto::class, 'user_id');
    }
}
