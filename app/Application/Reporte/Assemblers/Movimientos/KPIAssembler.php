<?php

namespace App\Application\Reporte\Assemblers\Movimientos;

use App\Application\Reporte\Contracts\AssemblerContract;
use App\Application\Reporte\Queries\Movimientos\KPI\PeriodKPIDTO;
use App\Application\Reporte\Queries\Movimientos\KPI\TotalsKPIDTO;
use App\Application\Reporte\Queries\Movimientos\KPI\VariationsKPIDTO;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Shared\Domain\Services\Financial\PercentageService;
use App\Application\Reporte\Assemblers\Abstracts\ReportAssembler;

/**
 * Ensamblador encargado de transformar ReporteQueryResult a PeriodKPIDTO para la capa de presentación.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class KPIAssembler extends ReportAssembler implements AssemblerContract
{
    protected ReportStatisticTypeContract $statisticType = MovimientoReportStatisticType::KPIS;

    public function __construct(
        private readonly PercentageService $percentageService
    ) {
    }

    protected function instanceof(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof MovimientoReportStatisticType ;
    }

    protected function buildAssemble(ReporteQueryResult $results): PeriodKPIDTO
    {
        $currentResults = $results->get(MovimientoReportStatisticType::KPIS);
        $previousResults = $results->getPrevious(MovimientoReportStatisticType::KPIS);
        return new PeriodKPIDTO(
            totales: new TotalsKPIDTO(
                ingresos: $currentResults->totalIngresos(),
                gastos: $currentResults->totalGastos(),
                balance_neto: $currentResults->totalBalance(),
                movimientos: $currentResults->totalMovimientos()
            ),
            variaciones: new VariationsKPIDTO(
                ingresos: $this->percentageService->calculatePercentageChange(
                    $currentResults->totalIngresos(),
                    $previousResults?->totalIngresos()
                ),
                gastos: $this->percentageService->calculatePercentageChange(
                    $currentResults->totalGastos(),
                    $previousResults?->totalGastos()
                ),
                balance_neto: $this->percentageService->calculatePercentageChange(
                    $currentResults->totalBalance(),
                    $previousResults?->totalBalance()
                ),
                movimientos: $this->percentageService->calculatePercentageChange(
                    (float) $currentResults->totalMovimientos(),
                    $previousResults !== null ? (float) $previousResults->totalMovimientos() : null
                )
            )
        );
    }
}
