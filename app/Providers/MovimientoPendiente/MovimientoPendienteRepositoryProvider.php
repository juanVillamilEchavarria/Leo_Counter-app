<?php

namespace App\Providers$domain\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteReadRepositoryContract;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteWriteRepositoryContract;
use App\Infrastructure\MovimientoPendiente\Persistence\Repositories\Eloquent\EloquentMovimientoPendienteReadRepository;
use App\Infrastructure\MovimientoPendiente\Persistence\Repositories\Eloquent\EloquentMovimientoPendienteWriteRepository;

class MovimientoPendienteRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(MovimientoPendienteReadRepositoryContract::class, EloquentMovimientoPendienteReadRepository::class);
        $this->app->singleton(MovimientoPendienteWriteRepositoryContract::class, EloquentMovimientoPendienteWriteRepository::class);
    }

}
