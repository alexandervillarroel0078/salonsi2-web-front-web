<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_price',
        'has_discount',
        'image_path',
        'active',
    ];

    public function servicios()
    {
        return $this->belongsToMany(Service::class, 'combo_service', 'combo_id', 'service_id');
    }
}
