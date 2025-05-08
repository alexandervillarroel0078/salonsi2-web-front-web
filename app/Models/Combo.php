<?php
// app/Models/Combo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',       // ✅ agregado
        'price',
        'discount_price',
        'has_discount',
        'image_path',
        'active'             // ✅ agregado
    ];
    public function services()
    {
        return $this->belongsToMany(Service::class, 'combo_service');
    }
}
