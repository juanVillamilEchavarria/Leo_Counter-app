<?php

namespace App\Domains\MovimientoFijo\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\MovimientoFijo\Repositories\Contracts\MovimientoFijoReadRepositoryContract;
use App\Domains\MovimientoFijo\Repositories\Application\Eloquent\EloquentMovimientoFijoReadRepository;

class MovimientoFijoRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(MovimientoFijoReadRepositoryContract::class, EloquentMovimientoFijoReadRepository::class);
    }

}
