<?php

namespace App\Providers$domain\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoReadRepositoryContract;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoWriteRepositoryContract;
use App\Infrastructure\MovimientoFijo\Persistence\Repositories\Eloquent\EloquentMovimientoFijoReadRepository;
use App\Infrastructure\MovimientoFijo\Persistence\Repositories\Eloquent\EloquentMovimientoFijoWriteRepository;

class MovimientoFijoRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(MovimientoFijoReadRepositoryContract::class, EloquentMovimientoFijoReadRepository::class);
        $this->app->singleton(MovimientoFijoWriteRepositoryContract::class, EloquentMovimientoFijoWriteRepository::class);
    }

}
