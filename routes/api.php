<?php
// routes/api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::post('/flutter-login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'message' => 'Login exitoso',
            'user' => $user,
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Credenciales inválidas',
    ], 401);
});
