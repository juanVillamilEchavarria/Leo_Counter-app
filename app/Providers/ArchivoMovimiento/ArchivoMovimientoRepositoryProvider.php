<?php

namespace App\Providers\ArchivoMovimiento;

use Illuminate\Support\ServiceProvider;
use App\Domains\ArchivoMovimiento\Contracts\Repositories\ArchivoMovimientoReadRepositoryContract;
use App\Domains\ArchivoMovimiento\Contracts\Repositories\ArchivoMovimientoRepositoryContract;
use App\Infrastructure\ArchivoMovimiento\Persistence\Repositories\Eloquent\EloquentArchivoMovimientoReadRepository;
use App\Infrastructure\ArchivoMovimiento\Persistence\Repositories\Eloquent\EloquentArchivoMovimientoRepository;

class ArchivoMovimientoRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ArchivoMovimientoReadRepositoryContract::class, EloquentArchivoMovimientoReadRepository::class);
        $this->app->singleton(ArchivoMovimientoRepositoryContract::class, EloquentArchivoMovimientoRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
