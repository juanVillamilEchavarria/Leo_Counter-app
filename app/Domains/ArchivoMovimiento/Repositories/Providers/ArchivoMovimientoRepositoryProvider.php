<?php

namespace App\Domains\ArchivoMovimiento\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\ArchivoMovimiento\Repositories\Contracts\ArchivoMovimientoReadRepositoryContract;
use App\Domains\ArchivoMovimiento\Repositories\Contracts\ArchivoMovimientoWriteRepositoryContract;
use App\Domains\ArchivoMovimiento\Repositories\Application\Eloquent\EloquentArchivoMovimientoReadRepository;
use App\Domains\ArchivoMovimiento\Repositories\Application\Eloquent\EloquentArchivoMovimientoWriteRepository;

class ArchivoMovimientoRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ArchivoMovimientoReadRepositoryContract::class, EloquentArchivoMovimientoReadRepository::class);
        $this->app->singleton(ArchivoMovimientoWriteRepositoryContract::class, EloquentArchivoMovimientoWriteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
