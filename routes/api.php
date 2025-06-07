<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

// Controllers
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\AuthClienteController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Api\SpecialistController;

// ===============================
// Autenticación
// ===============================

Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/cliente/login', [AuthClienteController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ===============================
// Personal
// ===============================

Route::get('/personales', [PersonalController::class, 'getList']);
Route::get('/personales/{id}', [PersonalController::class, 'getById']);

// ===============================
// API V1 - Endpoints públicos
// ===============================

Route::prefix('v1')->group(function () {
    Route::get('/servicios', [ApiController::class, 'listarServicios']);
    Route::get('/personal', [ApiController::class, 'listarPersonal']);
    Route::post('/crear-cita', [ApiController::class, 'crearCita']);
    Route::post('/registrar-pago', [ApiController::class, 'registrarPago']);
    Route::get('/cliente/{id}/citas', [ApiController::class, 'verCitasCliente']);
});
