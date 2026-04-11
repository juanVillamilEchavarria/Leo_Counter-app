<?php

namespace App\Application\Reporte\Projections;

use App\Domains\Reporte\Collections\KPICollection;
use App\Domains\Reporte\ValueObjects\KPI\PeriodKPIVO;
use App\Domains\Reporte\ValueObjects\KPI\TotalsKPIVO;
use App\Domains\Reporte\ValueObjects\KPI\VariationsKPIVO;
use App\Shared\Domain\Services\Financial\PercentageService;

final class KPIProjection
{
    public function __construct(
        private PercentageService $percentageService
    )
    {
    }
    public function assemble(KPICollection $currentResults, KPICollection $previousResults): PeriodKPIVO
    {
        $totalsVO = new TotalsKPIVO(
            ingresos: $currentResults->totalIngresos(),
            gastos: $currentResults->totalGastos(),
            balance_neto: $currentResults->totalBalance(),
            movimientos: $currentResults->totalMovimientos()
        ); 
        $variationsVO = new VariationsKPIVO(
            ingresos: $this->percentageService->calculatePercentageChange(
                $currentResults->totalIngresos(),
                $previousResults->totalIngresos()),
            gastos: $this->percentageService->calculatePercentageChange(
                $currentResults->totalGastos(),
                $previousResults->totalGastos()),
            balance_neto: $this->percentageService->calculatePercentageChange(
                $currentResults->totalBalance(),
                $previousResults->totalBalance()),
            movimientos: $this->percentageService->calculatePercentageChange(
                $currentResults->totalMovimientos(),
                $previousResults->totalMovimientos())
            );
        return new PeriodKPIVO(
            totales: $totalsVO,
            variaciones: $variationsVO
        );
    }
}
