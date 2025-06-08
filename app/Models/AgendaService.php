<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AgendaService extends Pivot
{
    protected $table = 'agenda_service';

    protected $fillable = [
        'agenda_id',
        'service_id',
        'personal_id',
        'cantidad', 
    ];

    public $timestamps = true;
}
