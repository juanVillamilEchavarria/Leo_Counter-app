<?php

namespace App\Domains\MovimientoPendiente\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\MovimientoPendiente\Repositories\Contracts\MovimientoPendienteReadRepositoryContract;
use App\Domains\MovimientoPendiente\Repositories\Contracts\MovimientoPendienteWriteRepositoryContract;
use App\Domains\MovimientoPendiente\Repositories\Application\Eloquent\EloquentMovimientoPendienteReadRepository;
use App\Domains\MovimientoPendiente\Repositories\Application\Eloquent\EloquentMovimientoPendienteWriteRepository;

class MovimientoPendienteRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(MovimientoPendienteReadRepositoryContract::class, EloquentMovimientoPendienteReadRepository::class);
        $this->app->singleton(MovimientoPendienteWriteRepositoryContract::class, EloquentMovimientoPendienteWriteRepository::class);
    }

}
