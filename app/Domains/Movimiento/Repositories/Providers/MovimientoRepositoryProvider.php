<?php

namespace App\Domains\Movimiento\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Movimiento\Repositories\Contracts\MovimientoReadRepositoryContract;
use App\Domains\Movimiento\Repositories\Contracts\MovimientoWriteRepositoryContract;
use App\Domains\Movimiento\Repositories\Application\Eloquent\EloquentMovimientoWriteRepository;
use App\Domains\Movimiento\Repositories\Application\Eloquent\EloquentMovimientoReadRepository;

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
