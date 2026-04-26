<?php

namespace App\Providers\TipoMovimiento;

use Illuminate\Support\ServiceProvider;
use App\Domains\TipoMovimiento\Contracts\Repositories\TipoMovimientoReadRepositoryContract;
use App\Domains\TipoMovimiento\Contracts\Repositories\TipoMovimientoRepositoryContract;
use App\Infrastructure\TipoMovimiento\Persistence\Repositories\Eloquent\EloquentTipoMovimientoReadRepository;
use App\Infrastructure\TipoMovimiento\Persistence\Repositories\Eloquent\EloquentTipoMovimientoRepository;

class TipoMovimientoRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(TipoMovimientoReadRepositoryContract::class, EloquentTipoMovimientoReadRepository::class);
        $this->app->singleton(TipoMovimientoRepositoryContract::class, EloquentTipoMovimientoRepository::class);
    }

}
