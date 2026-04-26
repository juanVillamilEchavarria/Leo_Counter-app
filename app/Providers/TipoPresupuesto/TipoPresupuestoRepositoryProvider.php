<?php

namespace App\Providers\TipoPresupuesto;

use Illuminate\Support\ServiceProvider;
use App\Domains\TipoPresupuesto\Contracts\Repositories\TipoPresupuestoReadRepositoryContract;
use App\Domains\TipoPresupuesto\Contracts\Repositories\TipoPresupuestoRepositoryContract;
use App\Infrastructure\TipoPresupuesto\Persistence\Repositories\Eloquent\EloquentTipoPresupuestoReadRepository;
use App\Infrastructure\TipoPresupuesto\Persistence\Repositories\Eloquent\EloquentTipoPresupuestoRepository;

class TipoPresupuestoRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TipoPresupuestoReadRepositoryContract::class, EloquentTipoPresupuestoReadRepository::class);
        $this->app->singleton(TipoPresupuestoRepositoryContract::class, EloquentTipoPresupuestoRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
