<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Movimiento\MovimientoEspontaneoController;


Route::middleware(['auth:sanctum'])->group( function () {
    Route::post('movimientos-espontaneos/validate-saldo', [MovimientoEspontaneoController::class, 'validateSaldo'])->name('movimientos-espontaneos.validate-saldo');
});
