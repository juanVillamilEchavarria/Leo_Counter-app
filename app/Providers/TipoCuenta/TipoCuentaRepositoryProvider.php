<?php

namespace App\Providers\TipoCuenta;

use Illuminate\Support\ServiceProvider;
use App\Domains\TipoCuenta\Contracts\Repositories\TipoCuentaReadRepositoryContract;
use App\Domains\TipoCuenta\Contracts\Repositories\TipoCuentaWriteRepositoryContract;
use App\Infrastructure\TipoCuenta\Persistence\Repositories\Eloquent\EloquentTipoCuentaReadRepository;
use App\Infrastructure\TipoCuenta\Persistence\Repositories\Eloquent\EloquentTipoCuentaWriteRepository;

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
