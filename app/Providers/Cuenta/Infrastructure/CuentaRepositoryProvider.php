<?php

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