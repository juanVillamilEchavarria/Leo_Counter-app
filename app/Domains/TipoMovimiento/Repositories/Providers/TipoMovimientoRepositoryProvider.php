<?php

namespace App\Domains\TipoMovimiento\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\TipoMovimiento\Repositories\Contracts\TipoMovimientoReadRepositoryContract;
use App\Domains\TipoMovimiento\Repositories\Contracts\TipoMovimientoWriteRepositoryContract;
use App\Domains\TipoMovimiento\Repositories\Application\Eloquent\EloquentTipoMovimientoReadRepository;
use App\Domains\TipoMovimiento\Repositories\Application\Eloquent\EloquentTipoMovimientoWriteRepository;

class TipoMovimientoRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(TipoMovimientoReadRepositoryContract::class, EloquentTipoMovimientoReadRepository::class);
        $this->app->singleton(TipoMovimientoWriteRepositoryContract::class, EloquentTipoMovimientoWriteRepository::class);
    }

}
