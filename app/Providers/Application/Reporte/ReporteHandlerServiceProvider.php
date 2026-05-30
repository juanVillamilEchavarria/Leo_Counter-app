<?php

namespace App\Providers\Application\Reporte;

use App\Application\Reporte\Contributors\MovimientoReportGenerationContributor;
use App\Application\Reporte\Contributors\PresupuestoReportGenerationContributor;
use App\Application\Reporte\Handlers\GenerateReportHandler;
use App\Application\Reporte\Mappers\ReportQueryMapper;
use App\Application\Reporte\Orchestrators\MovimientoReportQueryOrchestrator;
use App\Application\Reporte\Orchestrators\PresupuestoReportQueryOrchestrator;
use Illuminate\Support\ServiceProvider;

/**
 * Proveedor de servicios para el módulo de reportes.
 * Registra los orchestrators, contribuidores y el handler compuesto.
 *
 * @author Juan Villamil
 * @since 1.0.0
 */
final class ReporteHandlerServiceProvider extends ServiceProvider
{
    /**
     * Registra los orchestrators y contribuidores del módulo de reportes.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->tag([
            MovimientoReportGenerationContributor::class,
            PresupuestoReportGenerationContributor::class,
        ], 'reporte.contributors');

        $this->app->bind(
            MovimientoReportQueryOrchestrator::class,
            static fn($app): MovimientoReportQueryOrchestrator => new MovimientoReportQueryOrchestrator(
                executors: $app->tagged('reporte.movimiento.query.executors'),
            )
        );

        $this->app->bind(
            PresupuestoReportQueryOrchestrator::class,
            static fn($app): PresupuestoReportQueryOrchestrator => new PresupuestoReportQueryOrchestrator(
                executors: $app->tagged('reporte.presupuesto.query.executors'),
            )
        );

        $this->app->bind(
            GenerateReportHandler::class,
            static fn($app): GenerateReportHandler => new GenerateReportHandler(
                mapper: $app->make(ReportQueryMapper::class),
                contributors: $app->tagged('reporte.contributors'),
            )
        );

    }
}
