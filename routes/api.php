<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Shared\SaldoValidateController;
use App\Http\Controllers\Api\Movimiento\MovimientoApiController;
use App\Http\Controllers\Api\Presupuesto\PresupuestoHistoricoApiController;
use App\Http\Controllers\Api\Reporte\ReporteApiController;

Route::middleware(['auth'])->group( function () {
    Route::post('validate-saldo', SaldoValidateController::class)->name('validate-saldo');
    Route::get('movimientos', [MovimientoApiController::class, 'totalPaginated'])->name('movimientos.total-paginated');
    Route::get('presupuestos/historicos', [PresupuestoHistoricoApiController::class, 'historicosPaginated'])->name('presupuestos.historicos-paginated');
    Route::get('reportes', [ReporteApiController::class, 'index'])->name('api.reportes.index');
});
