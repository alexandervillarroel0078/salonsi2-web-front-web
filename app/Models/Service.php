<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Models\ServiceImage;
use App\Models\Personal;

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
        'image_path',
        'tipo_atencion' // Si decides agregarlo
    ];

    // Mutador para obtener la imagen con URL pública
    public function getImagePathAttribute($value)
    {
        if (Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }

        return $value ? asset('storage/' . $value) : null;
    }

    // Relación con el especialista (Personal)
    public function specialist(): BelongsTo
    {
        return $this->belongsTo(Personal::class, 'specialist_id');
    }

    // Relación con las imágenes del servicio
    public function images(): HasMany
    {
        return $this->hasMany(ServiceImage::class);
    }
    public function personals()
    {
        return $this->belongsToMany(Personal::class, 'personal_service');
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_service');
    }
    public function combos()
    {
        return $this->belongsToMany(Combo::class, 'combo_service');
    }
}
