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
use App\Http\Controllers\CargoPersonalController;

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\ExportServiceController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ExportAgendaController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\PDFController;

use App\Http\Controllers\CategoriaGastoController;
use App\Http\Controllers\ComisionController;
use App\Http\Controllers\GastoController;

Route::get('/test-pdf', function () {
    return \Barryvdh\DomPDF\Facade\Pdf::loadHTML('<h1>Hola desde PDF</h1>')->download('test.pdf');
});
Route::resource('users', UsuarioController::class);


Route::get('/prueba-pdf', [PDFController::class, 'prueba']);
Route::get('/agendas/export/pdf', [App\Http\Controllers\AgendaController::class, 'exportPDF'])->name('agendas.export.pdf');


Route::middleware(['auth'])->prefix('backups')->group(function () {
    Route::get('/', [BackupController::class, 'index'])->name('backups.index');
    Route::get('/run', [BackupController::class, 'run'])->name('backups.run');
    Route::get('/download/{filename}', [BackupController::class, 'download'])->name('backups.download');
    Route::delete('/{filename}', [BackupController::class, 'destroy'])->name('backups.destroy');
});


// al principio debe ir export 
Route::get('/horarios/export', [HorarioController::class, 'export'])->name('horarios.export');

Route::get('/personals/export', [PersonalController::class, 'export'])->name('personals.export');
Route::get('/clientes/export', [ClienteController::class, 'export'])->name('clientes.export');
Route::get('/agendas/export', [AgendaController::class, 'export'])->name('agendas.export');
Route::get('/productos/export', [ProductoController::class, 'export'])->name('productos.export');
Route::get('/agendas/exportar-csv', [ExportAgendaController::class, 'exportCSV'])->name('agendas.export.csv');
Route::get('/agendas/exportar-excel', [ExportAgendaController::class, 'exportExcel'])->name('agendas.export.excel');
Route::get('/agendas/search-ajax', [App\Http\Controllers\AgendaController::class, 'searchAjax'])->name('agendas.searchAjax');


Route::post('/agendas', [AgendaController::class, 'store'])->name('agendas.store');
 

//services

Route::get('/services/export', [ServiceController::class, 'export'])->name('services.export');
Route::prefix('services')->name('services.')->group(function () {
    Route::get('/search-ajax', [ServiceController::class, 'searchAjax'])->name('searchAjax');
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::resource('/', ServiceController::class)->except(['index']);
});

//personal
Route::get('/personals/search-ajax', [App\Http\Controllers\PersonalController::class, 'searchAjax'])->name('personals.searchAjax');
Route::resource('personals', PersonalController::class);
Route::prefix('empleados/cargo')->group(function () {
    Route::get('/', [CargoPersonalController::class, 'index'])->name('cargos.index');
    Route::get('/crear', [CargoPersonalController::class, 'create'])->name('cargos.create');
    Route::post('/', [CargoPersonalController::class, 'store'])->name('cargos.store');
    Route::get('/{id}/editar', [CargoPersonalController::class, 'edit'])->name('cargos.edit');
    Route::put('/{id}', [CargoPersonalController::class, 'update'])->name('cargos.update');
    Route::delete('/{id}', [CargoPersonalController::class, 'destroy'])->name('cargos.destroy');
});


//clientes
Route::get('/clientes/search-ajax', [ClienteController::class, 'searchAjax'])->name('clientes.searchAjax');
Route::resource('clientes', ClienteController::class);
Route::get('/mis-citas', [AgendaController::class, 'misCitas'])
    
    ->name('clientes.agenda.index');


Route::get('cliente/agendas/{id}/confirmar', [ClienteController::class, 'verMisCitasParaConfirmar'])->name('cliente.agenda.confirmar');
// Mostrar formulario de confirmación y calificación (GET)
// Procesar la confirmación y calificación (POST)
Route::post('cliente/agendas/{id}/confirmar', 
    [ClienteController::class, 'confirmarYCalificar']
)->name('cliente.agenda.confirmar.guardar');



// Bloque de inventario y productos con permisos 
Route::group(['middleware' => ['auth']], function () {

    // Inventario
    Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index')->can('ver inventario');
    Route::get('/inventario/movimientos', [InventarioController::class, 'movimientos'])->name('inventario.movimientos')->can('ver movimientos inventario');
    Route::get('/inventario/create', [InventarioController::class, 'create'])->name('inventario.create')->can('registrar movimientos inventario');
    Route::post('/inventario', [InventarioController::class, 'registrarMovimiento'])->name('inventario.movimiento')->can('registrar movimientos inventario');
    Route::get('/inventario/sucursal/{sucursal}', [InventarioController::class, 'porSucursal'])->name('inventario.sucursal');


    // Productos (CRUD completo)
    Route::resource('productos', ProductoController::class)->middleware('can:ver productos');
    Route::get('/productos/export', [ProductoController::class, 'export'])->name('productos.export')->can('ver productos');
    Route::resource('sucursales', SucursalController::class)->parameters([
        'sucursales' => 'sucursal'
    ]);
});

// Rutas para gestionar agenda

Route::resource('asistencias', AsistenciaController::class);
Route::resource('promotions', PromotionController::class);
Route::resource('combos', ComboController::class);
Route::resource('horarios', HorarioController::class);
 
// Rutas de autenticación
Route::get('/', [homeController::class, 'index'])->name('panel');
Route::get('/panel', [homeController::class, 'index']);
Route::resource('bitacora', BitacoraController::class);
Route::resource('roles', RoleController::class)->middleware('auth');
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

// routes/web.php
Route::get('/horarios/{personal}/edit', [HorarioController::class, 'edit'])->name('horarios.edit');
Route::put('/horarios/{personal}', [HorarioController::class, 'update'])->name('horarios.update');
Route::get('/agendas/{id}/pdf', [AgendaController::class, 'exportPdf'])->name('agendas.pdf');
Route::get('/horarios/export', [HorarioController::class, 'export'])->name('horarios.export');
Route::get('/personal/mis-citas', [App\Http\Controllers\PersonalController::class, 'misCitasAsignadas'])
    ->name('personals.mis_citas')
    ->middleware(['auth']);
Route::get('/personal/citas/{agenda}', [PersonalController::class, 'verDetalleCita'])->name('personals.citas.show');


Route::put('/personals/agenda/{agenda}/servicio/{servicio}/finalizar', [PersonalController::class, 'finalizarServicio'])
    ->name('personals.servicio.finalizar');
Route::get('/personal/mis-servicios', [PersonalController::class, 'misServicios'])
    ->name('personal.mis_servicios');


Route::get('/perfil', function () {
    return view('users.perfil');
})->name('perfil');
Route::get('/soporte', function () {
    return view('soporte');
})->name('soporte')->middleware('auth');
Route::get('/sugerencias', function () {
    return view('sugerencias');
})->name('sugerencias.index');

use App\Http\Controllers\PagoController;

Route::get('/pagos/qr/{agenda}', [PagoController::class, 'pagarConQR'])->name('pagos.qr');
Route::post('/pagos/stripe/{agenda}', [PagoController::class, 'pagarConStripe'])->name('pagos.stripe');
Route::post('/pagos/qr/confirmar/{agenda}', [PagoController::class, 'confirmarPagoQR'])->name('pagos.qr.confirmar');
Route::get('/pagos/stripe/success/{agendaId}', [PagoController::class, 'stripeSuccess'])->name('pagos.success');




Route::resource('comisiones', ComisionController::class);
Route::resource('gastos', GastoController::class);
Route::resource('categorias-gasto', CategoriaGastoController::class);
