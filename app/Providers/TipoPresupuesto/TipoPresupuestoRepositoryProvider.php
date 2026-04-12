<?php

namespace App\Providers$domain\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\TipoPresupuesto\Contracts\Repositories\TipoPresupuestoReadRepositoryContract;
use App\Domains\TipoPresupuesto\Contracts\Repositories\TipoPresupuestoWriteRepositoryContract;
use App\Infrastructure\TipoPresupuesto\Persistence\Repositories\Eloquent\EloquentTipoPresupuestoReadRepository;
use App\Infrastructure\TipoPresupuesto\Persistence\Repositories\Eloquent\EloquentTipoPresupuestoWriteRepository;

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
