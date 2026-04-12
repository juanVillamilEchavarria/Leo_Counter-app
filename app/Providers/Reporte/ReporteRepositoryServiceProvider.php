<?php

namespace App\Providers\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Reporte\Queries\Adapters\Movimientos\Eloquent\EloquentMovimientoReporteQueryAdapter;
use App\Infrastructure\Reporte\Queries\Adapters\Presupuestos\Eloquent\EloquentPresupuestoReporteQueryAdapter;

final class ReporteRepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            EloquentMovimientoReporteQueryAdapter::class,
            EloquentPresupuestoReporteQueryAdapter::class,
        ], 'reporte.repositories');
    }
}
