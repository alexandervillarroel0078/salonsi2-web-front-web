<?php
// routes/api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\AuthApiController;
 
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Api\SpecialistController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AuthClienteController;
use App\Http\Controllers\EmpleadoController;

 
Route::post('/cliente/login', [AuthClienteController::class, 'login']);

Route::get('/personales', [PersonalController::class, 'getList']);
Route::get('/personales/{id}', [PersonalController::class, 'getById']);
 
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 

Route::get('/especialistas', [PersonalController::class, 'getList']);
Route::get('/servicios', [ServiceController::class, 'getList']);
Route::get('/combos', [ComboController::class, 'getList']);
Route::get('/promociones', [PromotionController::class, 'getList']);
Route::get('/clientes/{id}', [ClienteController::class, 'show']);
Route::get('/clientes/{id}/citas', [AgendaController::class, 'getCitasPorCliente']);
Route::get('/combos', [ComboController::class, 'getListApi']);
Route::get('/promotions', [PromotionController::class, 'getList']);
Route::post('/agendas', [AgendaController::class, 'store']);
