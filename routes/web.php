<?php
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\userController;
use App\Http\Controllers\usuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicioController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\residenteController;
use App\Http\Controllers\bitacoraController;
use App\Http\Controllers\empleadoController;
use App\Http\Controllers\CargoEmpleadoController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PersonalController;  
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\PromotionController;


use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AgendaController;

// Rutas para gestionar agenda
Route::resource('agendas', AgendaController::class)->names('agendas');

Route::resource('asistencias', AsistenciaController::class);


Route::resource('promotions', PromotionController::class);

Route::resource('combos', ComboController::class);



Route::resource('horarios', HorarioController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('personals', PersonalController::class);  
Route::resource('services', ServiceController::class);

Route::prefix('empleados/cargo')->group(function () {
    Route::get('/', [CargoEmpleadoController::class, 'index'])->name('cargos.index');
    Route::get('/crear', [CargoEmpleadoController::class, 'create'])->name('cargos.create');
    Route::post('/', [CargoEmpleadoController::class, 'store'])->name('cargos.store');
    Route::get('/{id}/editar', [CargoEmpleadoController::class, 'edit'])->name('cargos.edit');
    Route::put('/{id}', [CargoEmpleadoController::class, 'update'])->name('cargos.update');
    Route::delete('/{id}', [CargoEmpleadoController::class, 'destroy'])->name('cargos.destroy');
});


Route::get('/', [homeController::class, 'index'])->name('panel');
Route::get('/panel', [homeController::class, 'index']);
 
Route::resource('bitacora', BitacoraController::class);
Route::resource('roles', RoleController::class)->middleware('auth');

Route::resources([
    'users' => usuarioController::class,
    'residentes' => residenteController::class,
]);
Route::resource('empleados', App\Http\Controllers\empleadoController::class);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [logoutController::class, 'logout'])->name('logout');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/401', function () {
    return view('pages.401');
});
Route::get('/404', function () {
    return view('pages.404');
});
Route::get('/500', function () {
    return view('pages.500');
});
Route::get('/admin', function () {
    // Solo administradores
})->middleware('role:ADMINISTRADOR');
Route::get('/prueba-permiso', function () {
    return 'Tienes permiso';
})->middleware(['auth', 'permission:ver-role']);
 


Route::post('/api/flutter-login', function (Request $request) {
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