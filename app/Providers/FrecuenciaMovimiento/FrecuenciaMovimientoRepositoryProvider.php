<?php

namespace App\Providers\FrecuenciaMovimiento;

use Illuminate\Support\ServiceProvider;
use App\Domains\FrecuenciaMovimiento\Contracts\Repositories\FrecuenciaMovimientoReadRepositoryContract;
use App\Domains\FrecuenciaMovimiento\Contracts\Repositories\FrecuenciaMovimientoRepositoryContract;
use App\Infrastructure\FrecuenciaMovimiento\Persistence\Repositories\Eloquent\EloquentFrecuenciaMovimientoReadRepository;
use App\Infrastructure\FrecuenciaMovimiento\Persistence\Repositories\Eloquent\EloquentFrecuenciaMovimientoRepository;

class FrecuenciaMovimientoRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FrecuenciaMovimientoReadRepositoryContract::class, EloquentFrecuenciaMovimientoReadRepository::class);
        $this->app->singleton(FrecuenciaMovimientoRepositoryContract::class, EloquentFrecuenciaMovimientoRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
