<?php

namespace App\Providers$domain\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\FrecuenciaMovimiento\Contracts\Repositories\FrecuenciaMovimientoReadRepositoryContract;
use App\Domains\FrecuenciaMovimiento\Contracts\Repositories\FrecuenciaMovimientoWriteRepositoryContract;
use App\Infrastructure\FrecuenciaMovimiento\Persistence\Repositories\Eloquent\EloquentFrecuenciaMovimientoReadRepository;
use App\Infrastructure\FrecuenciaMovimiento\Persistence\Repositories\Eloquent\EloquentFrecuenciaMovimientoWriteRepository;

class FrecuenciaMovimientoRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FrecuenciaMovimientoReadRepositoryContract::class, EloquentFrecuenciaMovimientoReadRepository::class);
        $this->app->singleton(FrecuenciaMovimientoWriteRepositoryContract::class, EloquentFrecuenciaMovimientoWriteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
