<?php

namespace App\Providers\Infrastructure\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Persistence\Repositories\Eloquent\Reporte\EloquentMovimientoReporteRepository;
use App\Infrastructure\Persistence\Repositories\Eloquent\Reporte\EloquentPresupuestoReporteRepository;

class ReporteRepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            EloquentMovimientoReporteRepository::class,
            EloquentPresupuestoReporteRepository::class,
        ], 'reporte.repositories');
    }
}
