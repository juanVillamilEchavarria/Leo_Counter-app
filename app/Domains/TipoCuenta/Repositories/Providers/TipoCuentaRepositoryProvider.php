<?php

namespace App\Domains\TipoCuenta\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\TipoCuenta\Repositories\Contracts\TipoCuentaReadRepositoryContract;
use App\Domains\TipoCuenta\Repositories\Contracts\TipoCuentaWriteRepositoryContract;
use App\Domains\TipoCuenta\Repositories\Application\Eloquent\EloquentTipoCuentaReadRepository;
use App\Domains\TipoCuenta\Repositories\Application\Eloquent\EloquentTipoCuentaWriteRepository;

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
