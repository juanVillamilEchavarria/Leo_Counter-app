<?php

namespace App\Application\Presupuesto\Providers\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoReadRepositoryContract;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoWriteRepositoryContract;
use App\Infrastructure\Persistence\Repositories\Eloquent\Presupuesto\EloquentPresupuestoReadRepository;
use App\Infrastructure\Persistence\Repositories\Eloquent\Presupuesto\EloquentPresupuestoWriteRepository;

class PresupuestoRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PresupuestoReadRepositoryContract::class, EloquentPresupuestoReadRepository::class);
        $this->app->singleton(PresupuestoWriteRepositoryContract::class, EloquentPresupuestoWriteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
