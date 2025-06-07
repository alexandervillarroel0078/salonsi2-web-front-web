<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AgendaCliente extends Pivot
{
    protected $table = 'agenda_cliente';

    protected $fillable = [
        'agenda_id',
        'cliente_id',
    ];
}
