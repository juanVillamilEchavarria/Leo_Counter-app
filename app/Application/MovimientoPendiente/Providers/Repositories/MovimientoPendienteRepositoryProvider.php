<?php

namespace App\Application\MovimientoPendiente\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteReadRepositoryContract;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteWriteRepositoryContract;
use App\Infrastructure\Persistence\Repositories\Eloquent\MovimientoPendiente\EloquentMovimientoPendienteReadRepository;
use App\Infrastructure\Persistence\Repositories\Eloquent\MovimientoPendiente\EloquentMovimientoPendienteWriteRepository;

class MovimientoPendienteRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(MovimientoPendienteReadRepositoryContract::class, EloquentMovimientoPendienteReadRepository::class);
        $this->app->singleton(MovimientoPendienteWriteRepositoryContract::class, EloquentMovimientoPendienteWriteRepository::class);
    }

}
