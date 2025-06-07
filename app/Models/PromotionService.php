<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PromotionService extends Pivot
{
    protected $table = 'promotion_service';

    protected $fillable = [
        'promotion_id',
        'service_id',
    ];

    public $timestamps = true;
}
