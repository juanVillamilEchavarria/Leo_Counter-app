<?php

namespace App\Application\TipoCuenta\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\TipoCuenta\Contracts\Repositories\TipoCuentaReadRepositoryContract;
use App\Domains\TipoCuenta\Contracts\Repositories\TipoCuentaWriteRepositoryContract;
use App\Infrastructure\Persistence\Repositories\Eloquent\TipoCuenta\EloquentTipoCuentaReadRepository;
use App\Infrastructure\Persistence\Repositories\Eloquent\TipoCuenta\EloquentTipoCuentaWriteRepository;

class TipoCuentaRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TipoCuentaReadRepositoryContract::class, EloquentTipoCuentaReadRepository::class);
        $this->app->singleton(TipoCuentaWriteRepositoryContract::class, EloquentTipoCuentaWriteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
