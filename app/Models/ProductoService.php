<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoService extends Model
{
    use HasFactory;

    protected $table = 'producto_service';

    protected $fillable = [
        'producto_id',
        'service_id',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
