<?php

namespace App\Application\ArchivoMovimiento\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\ArchivoMovimiento\Contracts\Repositories\ArchivoMovimientoReadRepositoryContract;
use App\Domains\ArchivoMovimiento\Contracts\Repositories\ArchivoMovimientoWriteRepositoryContract;
use App\Infrastructure\Persistence\Repositories\Eloquent\ArchivoMovimiento\EloquentArchivoMovimientoReadRepository;
use App\Infrastructure\Persistence\Repositories\Eloquent\ArchivoMovimiento\EloquentArchivoMovimientoWriteRepository;

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
