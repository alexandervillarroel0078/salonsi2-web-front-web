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

Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 

Route::get('/especialistas', [PersonalController::class, 'getList']);
Route::get('/servicios', [ServiceController::class, 'getList']);
Route::get('/combos', [ComboController::class, 'getList']);
Route::get('/promociones', [PromotionController::class, 'getList']);
