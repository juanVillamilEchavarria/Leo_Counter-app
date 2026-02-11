<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shared\SaldoValidateController;

Route::middleware(['auth'])->group( function () {
    Route::post('validate-saldo', SaldoValidateController::class)->name('validate-saldo');
});
