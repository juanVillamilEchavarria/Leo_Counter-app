<?php

use App\Http\Controllers\Api\Exportacion\ExportacionApiController;
use App\Http\Controllers\Api\Home\HomeApiController;
use App\Http\Controllers\Api\Movimiento\MovimientoApiController;
use App\Http\Controllers\Api\Notificacion\SuscriptorApiController;
use App\Http\Controllers\Api\Presupuesto\PresupuestoHistoricoApiController;
use App\Http\Controllers\Api\Reporte\ReporteApiController;
use App\Http\Controllers\Api\Shared\SaldoValidateController;
use App\Http\Controllers\Api\Transferencia\TransferenciaApiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::middleware(['rate.limit:5,15,user_strict'])->group(function () {
        Route::post('export', ExportacionApiController::class)->name('api.export');
    });
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->prefix('exportaciones')->name('api.exportaciones.')->group(function () {
        Route::get('/', [ExportacionApiController::class, 'totalPaginated'])->name('index');
    });
    Route::post('validate-saldo', SaldoValidateController::class)->name('api.validate-saldo');
    Route::get('movimientos', [MovimientoApiController::class, 'totalPaginated'])->name('api.movimientos.total-paginated');
    Route::get('auditorias', [\App\Http\Controllers\Api\Auditoria\AuditoriaApiController::class, 'index'])->name('api.auditorias.index')->middleware([\App\Http\Middleware\AdminMiddleware::class]);
    Route::get('presupuestos/historicos', [PresupuestoHistoricoApiController::class, 'historicosPaginated'])->name('api.presupuestos.historicos-paginated');
    Route::get('reportes', [ReporteApiController::class, 'index'])->name('api.reportes.index');
    Route::post('reportes/generate', [ReporteApiController::class, 'generate'])->name('api.reportes.generate');
    Route::get('reportes/form-options', [ReporteApiController::class, 'formOptions'])->name('api.reportes.form-options');
    Route::get('home', [HomeApiController::class, 'index'])->name('api.home.index');
    Route::get('notificacion/suscriptores/form-options', [SuscriptorApiController::class, 'formOptions'])->name('api.notificaciones.suscriptor.form-options')->middleware([\App\Http\Middleware\AdminMiddleware::class]);
    Route::apiResource('notificacion/suscriptores', SuscriptorApiController::class)->only(['store', 'destroy'])->middleware([\App\Http\Middleware\AdminMiddleware::class]);
    Route::get('transferencias', [TransferenciaApiController::class, 'totalPaginated'])->name('api.transferencias.total-paginated');
});
