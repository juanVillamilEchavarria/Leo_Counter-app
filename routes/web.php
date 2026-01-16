<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Cuenta\CuentaController;
use App\Http\Controllers\Propietario\PropietarioController;
use App\Http\Controllers\Movimiento\MovimientoController;
use App\Http\Controllers\MovimientoFijo\MovimientoFijoController;
use App\Http\Controllers\Categoria\CategoriaController;
use App\Http\Controllers\Reporte\ReporteController;
use App\Http\Controllers\Presupuesto\PresupuestoHistoricoController;
use App\Http\Controllers\Presupuesto\PresupuestoMesActualController;
use App\Http\Controllers\PagoPendiente\PagoPendienteController;
use App\Http\Controllers\Historial\HistorialController;
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/register', function (){
    return view('auth.register');
})->name('register');
Route::middleware('auth')->group( function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // CUENTA
    Route::resource('cuentas',CuentaController::class)->names('cuentas')->except('patch');
    Route::patch('cuentas/{cuenta}/toggle-active', [CuentaController::class, 'toggleActive'])->name('cuentas.toggle-active');
    Route::resource('propietarios',PropietarioController::class)->names('propietarios');
    Route::get('/movimientos', [MovimientoController::class, 'index'])->name('movimientos.index');
    Route::resource('movimientos-fijos',MovimientoFijoController::class)->names('movimientosFijos');
    // CATEGORIAS
    Route::resource('categorias',CategoriaController::class)->names('categorias')->except('patch');
    Route::patch('categorias/{categoria}/es-fijo', [CategoriaController::class, 'toggleEsFijo'])->name('categorias.es-fijo');
    
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/presupuestos/historicos', [PresupuestoHistoricoController::class, 'index'])->name('presupuestosHistoricos.index');
    Route::resource('presupuestos/mes-actual', PresupuestoMesActualController::class)->names('presupuestosMesActual');
    Route::resource('pagos-pendientes',PagoPendienteController::class)->names('pagosPendientes');
    Route::get('/historial', [HistorialController::class, 'index'])->name('historial.index');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

