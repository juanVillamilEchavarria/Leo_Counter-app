<?php

namespace App\Providers\MovimientoFijo;

use Illuminate\Support\ServiceProvider;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoReadRepositoryContract;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoRepositoryContract;
use App\Infrastructure\MovimientoFijo\Persistence\Repositories\Eloquent\EloquentMovimientoFijoReadRepository;
use App\Infrastructure\MovimientoFijo\Persistence\Repositories\Eloquent\EloquentMovimientoFijoRepository;

class MovimientoFijoRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(MovimientoFijoReadRepositoryContract::class, EloquentMovimientoFijoReadRepository::class);
        $this->app->singleton(MovimientoFijoRepositoryContract::class, EloquentMovimientoFijoRepository::class);
    }

}
