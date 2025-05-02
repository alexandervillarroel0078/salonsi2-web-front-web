<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'discount_price',
        'duration_minutes',
        'specialist_id',
        'has_discount',
        'has_available',
        'image_path'
    ];
    

    public function getImagePathAttribute($value)
{
    // Si ya es una URL pública completa, no le añadas "storage/"
    if (Str::startsWith($value, ['http://', 'https://'])) {
        return $value;
    }

    // Si no, asume que es un archivo almacenado localmente
    return $value ? asset('storage/' . $value) : null;
}


    public function specialist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }
}
