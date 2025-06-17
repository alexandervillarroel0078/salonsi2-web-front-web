<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalService extends Model
{
    use HasFactory;

    protected $table = 'personal_service';

    protected $fillable = [
        'personal_id',
        'service_id',
        'comision_porcentaje',
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
