<?php

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
