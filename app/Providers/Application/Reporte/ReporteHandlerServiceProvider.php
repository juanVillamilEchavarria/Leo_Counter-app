<?php

namespace App\Providers\Application\Reporte;

use App\Application\Reporte\Handlers\GenerateFullFinancialReportHandler;
use App\Application\Reporte\Handlers\GenerateMovimientoReportHandler;
use App\Application\Reporte\Handlers\GeneratePresupuestoReportHandler;
use App\Application\Reporte\Mappers\ReportQueryMapper;
use Illuminate\Support\ServiceProvider;

/**
 * Proveedor de servicios para los handlers del módulo de Reportes.
 * Registra los contribuidores mediante tagged dependencies para que el
 * handler compuesto los reciba automáticamente desde el contenedor.
 *
 * @author Juan Villamil
 * @since 1.0.0
 */
final class ReporteHandlerServiceProvider extends ServiceProvider
{
    /**
     * Registra los handlers y contribuidores del módulo de reportes.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->tag([
            GenerateMovimientoReportHandler::class,
            GeneratePresupuestoReportHandler::class,
        ], 'reporte.contributors');

        $this->app->bind(
            GenerateFullFinancialReportHandler::class,
            static fn($app): GenerateFullFinancialReportHandler => new GenerateFullFinancialReportHandler(
                mapper: $app->make(ReportQueryMapper::class),
                contributors: $app->tagged('reporte.contributors'),
            )
        );
    }
}
