<?php

namespace App\Domains\FrecuenciaMovimiento\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\FrecuenciaMovimiento\Repositories\Contracts\FrecuenciaMovimientoReadRepositoryContract;
use App\Domains\FrecuenciaMovimiento\Repositories\Contracts\FrecuenciaMovimientoWriteRepositoryContract;
use App\Domains\FrecuenciaMovimiento\Repositories\Application\Eloquent\EloquentFrecuenciaMovimientoReadRepository;
use App\Domains\FrecuenciaMovimiento\Repositories\Application\Eloquent\EloquentFrecuenciaMovimientoWriteRepository;

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
