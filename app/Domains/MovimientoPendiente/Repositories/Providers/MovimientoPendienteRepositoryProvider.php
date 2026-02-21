<?php

namespace App\Domains\MovimientoPendiente\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\MovimientoPendiente\Repositories\Contracts\MovimientoPendienteReadRepositoryContract;
use App\Domains\MovimientoPendiente\Repositories\Application\Eloquent\EloquentMovimientoPendienteReadRepository;

class MovimientoPendienteRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(MovimientoPendienteReadRepositoryContract::class, EloquentMovimientoPendienteReadRepository::class);
    }

}
