<?php
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\residenteController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\CargoEmpleadoController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PersonalController;  
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ExportServiceController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AgendaController;
 use App\Http\Controllers\ExportAgendaController;
// al principio debe ir export 
Route::get('/horarios/export', [HorarioController::class, 'export'])->name('horarios.export');
Route::get('/services/export', [ServiceController::class, 'export'])->name('services.export');
Route::get('/personals/export', [PersonalController::class, 'export'])->name('personals.export');
Route::get('/clientes/export', [ClienteController::class, 'export'])->name('clientes.export');
Route::get('/agendas/export', [AgendaController::class, 'export'])->name('agendas.export');
Route::get('/agendas/exportar-csv', [ExportAgendaController::class, 'exportCSV'])->name('agendas.export.csv');
Route::get('/agendas/exportar-excel', [ExportAgendaController::class, 'exportExcel'])->name('agendas.export.excel');

 
Route::get('/personals/search-ajax', [App\Http\Controllers\PersonalController::class, 'searchAjax'])->name('personals.searchAjax');
Route::get('/clientes/search-ajax', [ClienteController::class, 'searchAjax'])->name('clientes.searchAjax');
Route::get('/agendas/search-ajax', [App\Http\Controllers\AgendaController::class, 'searchAjax'])->name('agendas.searchAjax');
Route::get('/services/search-ajax', [ServiceController::class, 'searchAjax'])->name('services.searchAjax');


// Rutas para gestionar agenda
Route::post('/agendas', [AgendaController::class, 'store'])->name('agendas.store');

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
 

// para copia de seguridads
use App\Http\Controllers\BackupController;
 
Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
Route::post('/backups/run', [BackupController::class, 'run'])->name('backups.run');

Route::get('/backups/download/{fileName}', [BackupController::class, 'download'])->name('backup.download');
Route::delete('/backups/destroy/{fileName}', [BackupController::class, 'destroy'])->name('backup.destroy');
Route::post('/backups/restore/{fileName}', [BackupController::class, 'restore'])->name('backup.restore');
 

use Illuminate\Support\Facades\Artisan;

Route::post('/backup/run', function () {
    Artisan::call('backup:run');
    return redirect()->back()->with('success', 'Backup hecho.');
})->name('backup.run');
 Route::resource('horarios', HorarioController::class)->except(['show']);
 Route::get('/asistencias/{personal}/{mes?}/{año?}', [AsistenciaController::class, 'show'])->name('asistencias.show');
 Route::get('horarios/{id}', [HorarioController::class, 'show'])->name('horarios.show');
 Route::resource('agendas', AgendaController::class);
 Route::resource('services', ServiceController::class);
// routes/web.php
Route::get('/cargos', [App\Http\Controllers\CargoEmpleadoController::class, 'index'])->name('cargo_empleados.index');
Route::get('/cargos', [CargoEmpleadoController::class, 'index'])->name('cargos.index');
Route::get('/horarios/{personal}/edit', [HorarioController::class, 'edit'])->name('horarios.edit');
Route::put('/horarios/{personal}', [HorarioController::class, 'update'])->name('horarios.update');
Route::get('/agendas/{id}/pdf', [AgendaController::class, 'exportPdf'])->name('agendas.pdf');
Route::get('/horarios/export', [HorarioController::class, 'export'])->name('horarios.export');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
 
 
Route::get('/services/export', [ServiceController::class, 'export'])->name('services.export');
Route::get('/perfil', function () {
    return view('users.perfil');
})->name('perfil');
Route::get('/soporte', function () {
    return view('soporte');
})->name('soporte')->middleware('auth');
Route::get('/sugerencias', function () {
    return view('sugerencias');
})->name('sugerencias.index');
