<?php

namespace App\Domains\MovimientoFijo\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\MovimientoFijo\Repositories\Contracts\MovimientoFijoReadRepositoryContract;
use App\Domains\MovimientoFijo\Repositories\Contracts\MovimientoFijoWriteRepositoryContract;
use App\Domains\MovimientoFijo\Repositories\Application\Eloquent\EloquentMovimientoFijoReadRepository;
use App\Domains\MovimientoFijo\Repositories\Application\Eloquent\EloquentMovimientoFijoWriteRepository;

class MovimientoFijoRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(MovimientoFijoReadRepositoryContract::class, EloquentMovimientoFijoReadRepository::class);
        $this->app->singleton(MovimientoFijoWriteRepositoryContract::class, EloquentMovimientoFijoWriteRepository::class);
    }

}
