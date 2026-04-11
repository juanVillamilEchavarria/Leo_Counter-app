<?php

namespace App\Application\Movimiento\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoReadRepositoryContract;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoWriteRepositoryContract;
use App\Infrastructure\Persistence\Repositories\Eloquent\Movimiento\EloquentMovimientoWriteRepository;
use App\Infrastructure\Persistence\Repositories\Eloquent\Movimiento\EloquentMovimientoReadRepository;

class MovimientoRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MovimientoReadRepositoryContract::class, EloquentMovimientoReadRepository::class);
        $this->app->singleton(MovimientoWriteRepositoryContract::class, EloquentMovimientoWriteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
