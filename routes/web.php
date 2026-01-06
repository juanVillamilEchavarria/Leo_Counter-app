<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Cuenta\CuentaController;
use App\Http\Controllers\Movimiento\MovimientoHistoricoController;
use App\Http\Controllers\Movimiento\MovimientoMesActualController;
use App\Http\Controllers\MovimientoFijo\MovimientoFijoController;
use App\Http\Controllers\Categoria\CategoriaController;
use App\Http\Controllers\Reporte\ReporteController;
use App\Http\Controllers\Presupuesto\PresupuestoController;
use App\Http\Controllers\PagoPendiente\PagoPendienteController;
use App\Http\Controllers\Historial\HistorialController;
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/register', function (){
    return view('auth.register');
})->name('register');
Route::middleware('auth')->group( function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('cuentas',CuentaController::class);
    Route::get('/movimientos/historicos', [MovimientoHistoricoController::class, 'index'])->name('movimientosHistoricos.index');
    Route::resource('movimientos/mes-actual',MovimientoMesActualController::class)->names('movimientosMesActual');
    Route::resource('movimientos-fijos',MovimientoFijoController::class)->names('movimientosFijos');
    Route::resource('categorias',CategoriaController::class)->names('categorias');
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::resource('presupuestos',PresupuestoController::class)->names('presupuestos');
    Route::resource('pagos-pendientes',PagoPendienteController::class)->names('pagosPendientes');
    Route::get('/historial', [HistorialController::class, 'index'])->name('historial.index');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

