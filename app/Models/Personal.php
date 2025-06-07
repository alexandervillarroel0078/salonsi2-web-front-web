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
    /**
     * Relación uno a muchos con Asistencia.
     * Este personal puede tener múltiples registros de asistencia.
     * La clave foránea 'personal_id' está en la tabla 'asistencias'.
     */
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'personal_id');
    }
    /**
     * Relación uno a muchos (1:N) con el modelo Asistencia.
     * Un personal puede tener múltiples registros de asistencia.
     * La clave foránea 'personal_id' está en la tabla 'asistencias'.
     */
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'personal_id');
    }

    // Agendas en las que participó
    public function agendas()
    {
        return $this->belongsToMany(Agenda::class, 'agenda_service', 'personal_id', 'agenda_id');
    }

    // Servicios que puede realizar (relación estructural)
    public function servicios()
    {
        return $this->belongsToMany(Service::class, 'personal_service', 'personal_id', 'service_id');
    }

    // Servicios que ha realizado en citas (relación contextual)
    public function serviciosRealizados()
    {
        return $this->belongsToMany(Service::class, 'agenda_service', 'personal_id', 'service_id');
    }

    /**
     * Relación uno a muchos inversa con CargoPersonal.
     * Este personal pertenece a un solo cargo.
     */
    public function cargo(): BelongsTo
    {
        return $this->belongsTo(CargoPersonal::class, 'cargo_personal_id');
    }

    /**
     * Relación opcional con el modelo User (si el personal inicia sesión).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
