<?php

namespace App\Providers\Movimiento;

use Illuminate\Support\ServiceProvider;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoReadRepositoryContract;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoRepositoryContract;
use App\Infrastructure\Movimiento\Persistence\Repositories\Eloquent\EloquentMovimientoRepository;
use App\Infrastructure\Movimiento\Persistence\Repositories\Eloquent\EloquentMovimientoReadRepository;

class MovimientoRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MovimientoRepositoryContract::class, EloquentMovimientoRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
