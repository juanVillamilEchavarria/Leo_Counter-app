<?php

namespace App\Application\MovimientoFijo\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoReadRepositoryContract;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoWriteRepositoryContract;
use App\Infrastructure\Persistence\Repositories\Eloquent\MovimientoFijo\EloquentMovimientoFijoReadRepository;
use App\Infrastructure\Persistence\Repositories\Eloquent\MovimientoFijo\EloquentMovimientoFijoWriteRepository;

class MovimientoFijoRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(MovimientoFijoReadRepositoryContract::class, EloquentMovimientoFijoReadRepository::class);
        $this->app->singleton(MovimientoFijoWriteRepositoryContract::class, EloquentMovimientoFijoWriteRepository::class);
    }

}
