<?php

namespace App\Providers\Cuenta;

use Illuminate\Support\ServiceProvider;
use App\Domains\Cuenta\Contracts\Repositories\CuentaReadRepositoryContract;
use App\Infrastructure\Cuenta\Persistence\Repositories\Eloquent\EloquentCuentaReadRepository;
use App\Infrastructure\Cuenta\Persistence\Repositories\Eloquent\EloquentCuentaWriteRepository;
use App\Domains\Cuenta\Contracts\Repositories\CuentaWriteRepositoryContract;

class CuentaRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CuentaReadRepositoryContract::class, EloquentCuentaReadRepository::class);
        $this->app->singleton(CuentaWriteRepositoryContract::class, EloquentCuentaWriteRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
