<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personal;

class SpecialistController extends Controller
{
    public function index()
    {
        $specialists = \App\Models\Personal::select(
            'id',
            'name as nombre',
            'photo_url as foto',
            'email as correo',
            'phone as telefono'
        )->where('status', true)
            ->get();

        return response()->json($specialists);
    }
}
