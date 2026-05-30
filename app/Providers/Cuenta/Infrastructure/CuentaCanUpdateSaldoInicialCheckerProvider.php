<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Cuenta\Infrastructure;

use App\Domains\Cuenta\Contracts\CuentasUniquenessCheckerContract;
use App\Infrastructure\Cuenta\Persistence\Checkers\Eloquent\EloquentCuentaUniquenessChecker;
use App\Domains\Cuenta\Contracts\CuentaCanUpdateSaldoInicialCheckerContract;
use App\Infrastructure\Cuenta\Persistence\Checkers\Eloquent\EloquentCuentaCanUpdateSaldoInicialChecker;
use Illuminate\Support\ServiceProvider;

class CuentaCanUpdateSaldoInicialCheckerProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CuentaCanUpdateSaldoInicialCheckerContract::class, EloquentCuentaCanUpdateSaldoInicialChecker::class);
    }

    public function boot(): void
    {
        //
    }
}