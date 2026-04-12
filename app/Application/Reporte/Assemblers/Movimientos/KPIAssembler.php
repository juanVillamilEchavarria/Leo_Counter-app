<?php

namespace App\Application\Reporte\Assemblers\Movimientos;

use App\Application\Reporte\DTOs\KPI\PeriodKPIDTO;
use App\Application\Reporte\DTOs\KPI\TotalsKPIDTO;
use App\Application\Reporte\DTOs\KPI\VariationsKPIDTO;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Shared\Domain\Services\Financial\PercentageService;

/**
 * Ensamblador encargado de transformar ReporteQueryResult a PeriodKPIDTO para la capa de presentación.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class KPIAssembler
{

    public function __construct(
        private readonly PercentageService $percentageService
    ) {
    }

    public function assemble(ReporteQueryResult $results): PeriodKPIDTO | null
    {
        if(!$results->has(MovimientoReportStatisticType::KPIS)){
            return null;
        }
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
