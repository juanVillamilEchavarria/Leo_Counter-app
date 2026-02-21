<?php

namespace App\Domains\TipoMovimiento\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\TipoMovimiento\Repositories\Contracts\TipoMovimientoReadRepositoryContract;
use App\Domains\TipoMovimiento\Repositories\Application\Eloquent\EloquentTipoMovimientoReadRepository;

class TipoMovimientoRepositoryProvider extends ServiceProvider {

    public function register(): void
    {
        $this->app->bind(TipoMovimientoReadRepositoryContract::class, EloquentTipoMovimientoReadRepository::class);
    }

}
