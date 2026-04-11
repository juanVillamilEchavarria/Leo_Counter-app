<?php

namespace App\Application\TipoPresupuesto\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\TipoPresupuesto\Contracts\Repositories\TipoPresupuestoReadRepositoryContract;
use App\Domains\TipoPresupuesto\Contracts\Repositories\TipoPresupuestoWriteRepositoryContract;
use App\Infrastructure\Persistence\Repositories\Eloquent\TipoPresupuesto\EloquentTipoPresupuestoReadRepository;
use App\Infrastructure\Persistence\Repositories\Eloquent\TipoPresupuesto\EloquentTipoPresupuestoWriteRepository;

class TipoPresupuestoRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TipoPresupuestoReadRepositoryContract::class, EloquentTipoPresupuestoReadRepository::class);
        $this->app->singleton(TipoPresupuestoWriteRepositoryContract::class, EloquentTipoPresupuestoWriteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
