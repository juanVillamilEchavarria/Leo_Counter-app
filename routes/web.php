<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Cuenta\CuentaController;
use App\Http\Controllers\Propietario\PropietarioController;
use App\Http\Controllers\Movimiento\MovimientoController;
use App\Http\Controllers\Movimiento\MovimientoEspontaneoController;
use App\Http\Controllers\MovimientoPendiente\MovimientoPendienteController;
use App\Http\Controllers\MovimientoFijo\MovimientoFijoController;
use App\Http\Controllers\ArchivoMovimiento\ArchivoMovimientoController;
use App\Http\Controllers\Categoria\CategoriaController;
use App\Http\Controllers\Reporte\ReporteController;
use App\Http\Controllers\Presupuesto\PresupuestoHistoricoController;
use App\Http\Controllers\Presupuesto\PresupuestoMesActualController;
use App\Http\Controllers\PagoPendiente\PagoPendienteController;
use App\Http\Controllers\Historial\HistorialController;
use App\Http\Controllers\Usuario\UsuarioController;
use App\Http\Controllers\Configuracion\ConfiguracionController;
use App\Http\Controllers\Configuracion\SoftDeleteRecordsController;
use App\Http\Controllers\Notificacion\CanalNotificacionController;
use App\Http\Controllers\Notificacion\SuscriptorController;
use App\Http\Controllers\Notificacion\SuscriptorVerificationController;
use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    Mail::raw('¡Hola desde Leo Counter!', function ($message) {
        $message->to('juan@example.com')
            ->subject('Prueba de envío');
    });
    return 'Correo enviado';
});
// GUEST ROUTES
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');
// SUSCRIPCIÓN de notificaciones
Route::get('/suscriptores/verificar/{suscriptorId}', [SuscriptorVerificationController::class, 'verify'])
    ->name('configuracion.notificaciones.suscriptores.verify')
    ->middleware('signed');
// AUTH ROUTES
Route::middleware('auth')->group( function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // CUENTAS
    Route::resource('cuentas',CuentaController::class)->names('cuentas')->except('patch');
    Route::patch('cuentas/{cuenta}/{attribute}/toggle', [CuentaController::class, 'toggleActive'])->name('cuentas.toggle');
    Route::resource('propietarios',PropietarioController::class)->names('propietarios');
    // MOVIMIENTOS
    Route::get('/movimientos/historicos', [MovimientoController::class, 'index'])->name('movimientos.index');
    Route::get('/movimientos/historicos/{movimiento}', [MovimientoController::class, 'show'])->name('movimientos.show');
    //MOVIMIENTOS ESPONTANEOS
    Route::resource('movimientos-espontaneos',MovimientoEspontaneoController::class)->names('movimientosEspontaneos')->parameters([
        'movimientos-espontaneos'=> 'movimientoEspontaneo'
    ]);
    // MOVIMIENTOS PENDIENTES
    Route::resource('movimientos-pendientes',MovimientoPendienteController::class)->names('movimientosPendientes')->parameters([
        'movimientos-pendientes'=> 'movimientoPendiente'
    ]);
    Route::patch('movimientos-pendientes/{movimientoPendiente}/mark-as-done', [MovimientoPendienteController::class, 'markAsDone'])->name('movimientosPendientes.markAsDone');
    // MOVIMIENTOS FIJOS
    Route::resource('movimientos-fijos',MovimientoFijoController::class)->names('movimientosFijos')->parameters([
        'movimientos-fijos'=> 'id'
    ]);
    // ARCHIVOS_MOVIMIENTOS
    Route::get('movimientos/archivos/{archivoMovimiento}', [ArchivoMovimientoController::class, 'show'])->name('movimientos.archivos.show');
    Route::get('movimientos/archivos/{archivoMovimiento}/download', [ArchivoMovimientoController::class, 'download'])->name('movimientos.archivos.download');

    Route::patch('movimientos-fijos/{id}/{attribute}/toggle', [MovimientoFijoController::class, 'toggle'])->name('movimientosFijos.toggle');
    // CATEGORIAS
    Route::resource('categorias',CategoriaController::class)->names('categorias')->except('patch');
    Route::patch('categorias/{categoria}/{attribute}/toggle', [CategoriaController::class, 'toggleEsFijo'])->name('categorias.toggle');

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    // PRESUPUESTOS
    Route::get('/presupuestos/historicos', [PresupuestoHistoricoController::class, 'index'])->name('presupuestosHistoricos.index');
    // PRESUPUESTOS MES ACTUAL
    Route::resource('presupuestos/mes-actual', PresupuestoMesActualController::class)->names('presupuestosMesActual')->parameters([
        'mes-actual' => 'presupuesto'
    ]);
    Route::post('presupuestos/mes-actual/{presupuesto}/duplicate', [PresupuestoMesActualController::class, 'duplicate'])->name('presupuestosMesActual.duplicate');
    // PAGOS PENDIENTES
    Route::resource('pagos-pendientes',PagoPendienteController::class)->names('pagosPendientes');
    Route::get('/historial', [HistorialController::class, 'index'])->name('historial.index');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    // USUARIO
    Route::get('/usuario', [UsuarioController::class, 'edit'])->name('usuario.edit');
    Route::put('/usuario', [UsuarioController::class, 'updateDatosPublicos'])->name('usuario.updateDatosPublicos');
    Route::get('/usuario/password', [UsuarioController::class, 'editPassword'])->name('usuario.password.edit');
    Route::put('/usuario/password', [UsuarioController::class, 'cambiarPassword'])->name('usuario.password.cambiar');
    //CONFIGURACION
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::resource('canal-notificaciones', CanalNotificacionController::class)->names('configuracion.notificaciones.canales');
    Route::patch('canal-notificaciones/{canal}/{attribute}/toggle', [CanalNotificacionController::class, 'toggle'])->name('configuracion.notificaciones.canales.toggle');
    Route::resource('suscriptor-notificaciones', SuscriptorController::class)->names('configuracion.notificaciones.suscriptores');
    Route::patch('suscriptor-notificaciones/{suscriptor}/{attribute}/toggle', [SuscriptorController::class, 'toggle'])->name('configuracion.notificaciones.suscriptores.toggle');
    // SOFT DELETES
    Route::get('/configuracion/deleted/{domain}', [SoftDeleteRecordsController::class, 'index'])->name('configuracion.deleted.index');
    Route::put('/configuracion/deleted/{domain}/restore/{id}', [SoftDeleteRecordsController::class, 'restore'])->name('configuracion.deleted.restore');
    Route::delete('/configuracion/deleted/{domain}/hard-delete/{id}', [SoftDeleteRecordsController::class, 'hardDelete'])->name('configuracion.deleted.hardDelete');
});
