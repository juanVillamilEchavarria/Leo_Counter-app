<?php

namespace App\Domains\Presupuesto\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Presupuesto\Repositories\Contracts\PresupuestoReadRepositoryContract;
use App\Domains\Presupuesto\Repositories\Contracts\PresupuestoWriteRepositoryContract;
use App\Domains\Presupuesto\Repositories\Application\Eloquent\EloquentPresupuestoReadRepository;
use App\Domains\Presupuesto\Repositories\Application\Eloquent\EloquentPresupuestoWriteRepository;

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
