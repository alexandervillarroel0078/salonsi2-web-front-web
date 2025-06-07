<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'discount_percentage',
        'start_date',
        'end_date',
        'active',
    ];
    public function servicios()
    {
        return $this->belongsToMany(Service::class, 'promotion_service', 'promotion_id', 'service_id');
    }
}
