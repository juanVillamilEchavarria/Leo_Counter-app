<?php

namespace App\Domains\Cuenta\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Cuenta\Repositories\Contracts\CuentaReadRepositoryContract;
use App\Domains\Cuenta\Repositories\Application\Eloquent\EloquentCuentaReadRepository;
use App\Domains\Cuenta\Repositories\Application\Eloquent\EloquentCuentaWriteRepository;
use App\Domains\Cuenta\Repositories\Contracts\CuentaWriteRepositoryContract;

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
