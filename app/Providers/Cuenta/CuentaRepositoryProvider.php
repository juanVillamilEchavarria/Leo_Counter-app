<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Cuenta;

use Illuminate\Support\ServiceProvider;
use App\Domains\Cuenta\Contracts\Repositories\CuentaReadRepositoryContract;
use App\Infrastructure\Cuenta\Persistence\Repositories\Eloquent\EloquentCuentaReadRepository;
use App\Infrastructure\Cuenta\Persistence\Repositories\Eloquent\EloquentCuentaRepository;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;

class CuentaRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CuentaReadRepositoryContract::class, EloquentCuentaReadRepository::class);
        $this->app->singleton(CuentaRepositoryContract::class, EloquentCuentaRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
