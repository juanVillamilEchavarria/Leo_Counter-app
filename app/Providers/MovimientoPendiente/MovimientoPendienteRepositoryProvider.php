<?php

namespace App\Providers\MovimientoPendiente;

use Illuminate\Support\ServiceProvider;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteReadRepositoryContract;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteRepositoryContract;
use App\Infrastructure\MovimientoPendiente\Persistence\Repositories\Eloquent\EloquentMovimientoPendienteReadRepository;
use App\Infrastructure\MovimientoPendiente\Persistence\Repositories\Eloquent\EloquentMovimientoPendienteRepository;

class MovimientoPendienteRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(MovimientoPendienteReadRepositoryContract::class, EloquentMovimientoPendienteReadRepository::class);
        $this->app->singleton(MovimientoPendienteRepositoryContract::class, EloquentMovimientoPendienteRepository::class);
    }

}
