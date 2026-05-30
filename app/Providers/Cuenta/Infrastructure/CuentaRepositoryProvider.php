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

use Illuminate\Support\ServiceProvider;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Infrastructure\Cuenta\Persistence\Repositories\Eloquent\EloquentCuentaRepository;

class CuentaRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CuentaRepositoryContract::class, EloquentCuentaRepository::class);
    }

    public function boot(): void
    {
        //
    }
}