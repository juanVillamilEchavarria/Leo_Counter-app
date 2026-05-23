<?php

use App\Http\Controllers\Api\Home\HomeApiController;
use App\Http\Controllers\Api\Movimiento\MovimientoApiController;
use App\Http\Controllers\Api\Notificacion\SuscriptorApiController;
use App\Http\Controllers\Api\Presupuesto\PresupuestoHistoricoApiController;
use App\Http\Controllers\Api\Reporte\ReporteApiController;
use App\Http\Controllers\Api\Shared\SaldoValidateController;
use App\Http\Controllers\Notificacion\SuscriptorVerificationController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group( function () {
    Route::post('validate-saldo', SaldoValidateController::class)->name('api.validate-saldo');
    Route::get('movimientos', [MovimientoApiController::class, 'totalPaginated'])->name('api.movimientos.total-paginated');
    Route::get('presupuestos/historicos', [PresupuestoHistoricoApiController::class, 'historicosPaginated'])->name('api.presupuestos.historicos-paginated');
    Route::get('reportes', [ReporteApiController::class, 'index'])->name('api.reportes.index');
    Route::post('reportes/generate', [ReporteApiController::class, 'generate'])->name('api.reportes.generate');
    Route::get('reportes/form-options', [ReporteApiController::class, 'formOptions'])->name('api.reportes.form-options');
    Route::get('home', [HomeApiController::class, 'index'])->name('api.home.index');
    Route::get('notificacion/suscriptores/form-options', [SuscriptorApiController::class, 'formOptions'])->name('api.notificaciones.suscriptor.form-options');
    Route::apiResource('notificacion/suscriptores', SuscriptorApiController::class)->only(['store', 'update', 'destroy']);

});
