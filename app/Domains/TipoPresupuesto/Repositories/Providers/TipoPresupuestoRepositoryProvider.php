<?php

namespace App\Domains\TipoPresupuesto\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\TipoPresupuesto\Repositories\Contracts\TipoPresupuestoReadRepositoryContract;
use App\Domains\TipoPresupuesto\Repositories\Contracts\TipoPresupuestoWriteRepositoryContract;
use App\Domains\TipoPresupuesto\Repositories\Application\Eloquent\EloquentTipoPresupuestoReadRepository;
use App\Domains\TipoPresupuesto\Repositories\Application\Eloquent\EloquentTipoPresupuestoWriteRepository;

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
