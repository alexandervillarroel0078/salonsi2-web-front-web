<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personals';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo_url',
        'fecha_ingreso',
        'descripcion',
        'instagram',
        'facebook',
        'status',
        'cargo_personal_id',
    ];

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'personal_id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'personal_id');
    }

    public function agendas()
    {
        return $this->belongsToMany(Agenda::class, 'agenda_service', 'personal_id', 'agenda_id');
    }


    public function servicios()
    {
        return $this->belongsToMany(Service::class, 'personal_service', 'personal_id', 'service_id');
    }

    public function serviciosRealizados()
    {
        return $this->belongsToMany(Service::class, 'agenda_service', 'personal_id', 'service_id');
    }


    public function cargo(): BelongsTo
    {
        return $this->belongsTo(CargoPersonal::class, 'cargo_personal_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
