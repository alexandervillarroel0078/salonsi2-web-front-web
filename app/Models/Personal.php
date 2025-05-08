<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Especialidad;
use App\Models\CargoEmpleado;

class Personal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo_url',
        'fecha_ingreso',
        'descripcion',
        'instagram',
        'facebook',
        'status' => 'boolean',
        'cargo_empleado_id',
    ];

    public function cargo()
    {
        return $this->belongsTo(CargoEmpleado::class, 'cargo_empleado_id');
    }
    public function cargoEmpleado()
    {
        return $this->belongsTo(CargoEmpleado::class);
    }
    public function especialidades()
    {
        return $this->belongsToMany(Service::class, 'especialidad_personal');
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'personal_service');
    }
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
