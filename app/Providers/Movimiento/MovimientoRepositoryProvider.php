<?php

namespace App\Providers\Movimiento;

use Illuminate\Support\ServiceProvider;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoReadRepositoryContract;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoWriteRepositoryContract;
use App\Infrastructure\Movimiento\Persistence\Repositories\Eloquent\EloquentMovimientoWriteRepository;
use App\Infrastructure\Movimiento\Persistence\Repositories\Eloquent\EloquentMovimientoReadRepository;

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
