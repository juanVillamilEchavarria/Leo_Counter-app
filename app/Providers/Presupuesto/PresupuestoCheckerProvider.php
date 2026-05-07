<?php

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
