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
use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoCanDuplicateCheckerContract;
use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoUniquenessCheckerContract;
use App\Infrastructure\Presupuesto\Persistence\Checkers\Eloquent\EloquentPresupuestoCanDuplicateChecker;
use App\Infrastructure\Presupuesto\Persistence\Checkers\Eloquent\EloquentPresupuestoUniquenessChecker;

final class PresupuestoCheckerProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PresupuestoUniquenessCheckerContract::class, EloquentPresupuestoUniquenessChecker::class);
        $this->app->singleton(PresupuestoCanDuplicateCheckerContract::class, EloquentPresupuestoCanDuplicateChecker::class);
    }

    public function boot(): void
    {
        //
    }
}
