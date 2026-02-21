<?php

namespace App\Domains\Presupuesto\Repositories\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Presupuesto\Repositories\Contracts\PresupuestoReadRepositoryContract;
use App\Domains\Presupuesto\Repositories\Application\Eloquent\EloquentPresupuestoReadRepository;

class PresupuestoRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PresupuestoReadRepositoryContract::class, EloquentPresupuestoReadRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
