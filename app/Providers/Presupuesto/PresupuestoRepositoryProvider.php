<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Presupuesto;

use Illuminate\Support\ServiceProvider;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoReadRepositoryContract;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoRepositoryContract;
use App\Infrastructure\Presupuesto\Persistence\Repositories\Eloquent\EloquentPresupuestoReadRepository;
use App\Infrastructure\Presupuesto\Persistence\Repositories\Eloquent\EloquentPresupuestoRepository;

class PresupuestoRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PresupuestoRepositoryContract::class, EloquentPresupuestoRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
