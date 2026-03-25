<?php

namespace App\Domains\Reporte\QueryHandlers;


use App\Domains\Reporte\Repositories\Contracts\ReporteRepositoryContract;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Reporte\DTOs\KPI\PeriodKPIDTO;
use App\Domains\Reporte\Collections\KPICollection;
use App\Domains\Reporte\DTOs\KPI\TotalsKPIDTO;
use App\Domains\Reporte\DTOs\KPI\VariationsKPIDTO;
use App\Shared\Services\Financial\PercentageService;
use App\Domains\Reporte\ValueObjects\DateRange;
class KPIQueryHandler{
     public function __construct(
        private PercentageService $percentageService
    )
    {
    }
     public function apply(ReporteRepositoryContract $reporteRepository,ReporteQueryDTO $reporteQueryDTO) : PeriodKPIDTO {
      $data = $reporteRepository->getKPIs($reporteQueryDTO);
      $collection = KPICollection::fromQueryResults($data);
      $previousData = $this->getPreviousPeriodKPIs($reporteRepository,$reporteQueryDTO);
      $previousCollection = KPICollection::fromQueryResults($previousData);
      $totalsDTO = new TotalsKPIDTO(
        $collection->totalIngresos(),
        $collection->totalGastos(),
        $collection->totalBalance(),
        $collection->totalMovimientos()
      );
      $variationsDTO = new VariationsKPIDTO(
        ingresos: $this->percentageService->calculatePercentageChange($collection->totalIngresos(), $previousCollection->totalIngresos()),
        gastos: $this->percentageService->calculatePercentageChange($collection->totalGastos(), $previousCollection->totalGastos()),
        balance_neto: $this->percentageService->calculatePercentageChange($collection->totalBalance(), $previousCollection->totalBalance()),
        movimientos:  $this->percentageService->calculatePercentageChange($collection->totalMovimientos(), $previousCollection->totalMovimientos())
      );
      return new PeriodKPIDTO(
        totales: $totalsDTO,
        variaciones: $variationsDTO
      );
    }
      protected function getPreviousPeriodKPIs(ReporteRepositoryContract $reporteRepository,ReporteQueryDTO $reporteQueryDTO){
        // calcular la diferencia en días de las fechas
        $duration = $reporteQueryDTO->dateRange->startDate->diffInDays($reporteQueryDTO->dateRange->endDate);

        $previousStartDate = $reporteQueryDTO->dateRange->startDate->copy()->subDays($duration + 1);
        $previousEndDate = $reporteQueryDTO->dateRange->startDate->copy()->subDay();
        $dateRange = new DateRange($previousStartDate, $previousEndDate);

        $prevouisReporteQueryDTO = new ReporteQueryDTO(
            $reporteQueryDTO->granularityStrategy,
            $dateRange
        );
        return $reporteRepository->getKPIs($prevouisReporteQueryDTO);
    }
}