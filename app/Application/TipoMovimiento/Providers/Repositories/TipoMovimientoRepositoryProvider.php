<?php

namespace App\Application\TipoMovimiento\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\TipoMovimiento\Contracts\Repositories\TipoMovimientoReadRepositoryContract;
use App\Domains\TipoMovimiento\Contracts\Repositories\TipoMovimientoWriteRepositoryContract;
use App\Infrastructure\Persistence\Repositories\Eloquent\TipoMovimiento\EloquentTipoMovimientoReadRepository;
use App\Infrastructure\Persistence\Repositories\Eloquent\TipoMovimiento\EloquentTipoMovimientoWriteRepository;

class TipoMovimientoRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(TipoMovimientoReadRepositoryContract::class, EloquentTipoMovimientoReadRepository::class);
        $this->app->singleton(TipoMovimientoWriteRepositoryContract::class, EloquentTipoMovimientoWriteRepository::class);
    }

}
