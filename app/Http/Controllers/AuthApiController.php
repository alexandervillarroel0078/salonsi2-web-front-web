<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Traits\BitacoraTrait;

class AuthApiController extends Controller
{
    use BitacoraTrait;

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        $token = $user->createToken('flutter-token')->plainTextToken;
        $this->registrarEnBitacora('Login', 'Cliente inició sesión desde la app móvil', $user->id);
        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }


    public function logout(Request $request)
    {
        $this->registrarEnBitacora('Logout', 'Cliente cerró sesión desde la app móvil');
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
