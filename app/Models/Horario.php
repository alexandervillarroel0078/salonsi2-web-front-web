<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'personal_id',
        'day_name',       
        'date',
        'start_time',
        'end_time',
        'available',
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
    
}
