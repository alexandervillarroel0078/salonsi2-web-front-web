<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ComboService extends Pivot
{
    protected $table = 'combo_service';

    protected $fillable = [
        'combo_id',
        'service_id',
    ];
}
