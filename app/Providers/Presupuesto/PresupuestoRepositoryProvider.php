<?php

namespace App\Providers$domain\Repositories;

use Illuminate\Support\ServiceProvider;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoReadRepositoryContract;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoWriteRepositoryContract;
use App\Infrastructure\Presupuesto\Persistence\Repositories\Eloquent\EloquentPresupuestoReadRepository;
use App\Infrastructure\Presupuesto\Persistence\Repositories\Eloquent\EloquentPresupuestoWriteRepository;

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
