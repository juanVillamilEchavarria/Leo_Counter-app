<?php

namespace App\Providers\TipoMovimiento;

use Illuminate\Support\ServiceProvider;
use App\Domains\TipoMovimiento\Contracts\Repositories\TipoMovimientoReadRepositoryContract;
use App\Domains\TipoMovimiento\Contracts\Repositories\TipoMovimientoWriteRepositoryContract;
use App\Infrastructure\TipoMovimiento\Persistence\Repositories\Eloquent\EloquentTipoMovimientoReadRepository;
use App\Infrastructure\TipoMovimiento\Persistence\Repositories\Eloquent\EloquentTipoMovimientoWriteRepository;

class TipoMovimientoRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(TipoMovimientoReadRepositoryContract::class, EloquentTipoMovimientoReadRepository::class);
        $this->app->singleton(TipoMovimientoWriteRepositoryContract::class, EloquentTipoMovimientoWriteRepository::class);
    }

}
