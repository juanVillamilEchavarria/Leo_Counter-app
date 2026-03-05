<?php

namespace App\Domains\Reporte\Services\Domain;

use App\Domains\Reporte\Repositories\Contracts\ReporteRepositoryContract;
use App\Domains\Reporte\Collections\FinancialMonthCollection;
use App\Domains\Reporte\Collections\DistributionCategoryCollection;
use App\Domains\Reporte\Collections\KPICollection;
use App\Shared\Services\Financial\PercentageService;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Reporte\DTOs\KPI\PeriodKPIDTO;
use App\Domains\Reporte\DTOs\KPI\TotalsKPIDTO;
use App\Domains\Reporte\DTOs\KPI\VariationsKPIDTO;
use App\Domains\Reporte\DTOs\IngresosVsGastos\IngresosVsGastosDTO;
use App\Domains\Reporte\DTOs\Promedio\PromedioDTO;
use App\Domains\Reporte\DTOs\Category\FullDistributionCategoryDTO;
use App\Domains\Reporte\DTOs\Budget\UsedBudgetDTO;

class ReporteQueryService {
    public function __construct(
        private ReporteRepositoryContract $reporteRepository,
        private PercentageService $percentageService
    )
    {
    }

    public function getPeriodKPIs(ReporteQueryDTO $reporteQueryDTO) : PeriodKPIDTO {
      $data = $this->reporteRepository->getKPIs($reporteQueryDTO->startDate, $reporteQueryDTO->endDate);
      $collection = KPICollection::fromQueryResults($data);
      $previousData = $this->getPreviousPeriodKPIs($reporteQueryDTO);
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

    public function getIngresosVsGastos(ReporteQueryDTO $reporteQueryDTO){
        $data = $this->reporteRepository->getIngresosVsGastos($reporteQueryDTO->startDate, $reporteQueryDTO->endDate);
        $collection = FinancialMonthCollection::fromQueryResults($data);
        $promedioDTO = new PromedioDTO(
            $collection->promedioIngresos(),
            $collection->promedioGastos()
        );
        return new IngresosVsGastosDTO(
            $collection,
            $promedioDTO
        );
    }

    public function getDistributionByCategory(ReporteQueryDTO $reporteQueryDTO, int $tipo_movimiento_id): FullDistributionCategoryDTO{
        $data = $this->reporteRepository->getDistributionByCategory($reporteQueryDTO->startDate, $reporteQueryDTO->endDate, $tipo_movimiento_id);
        $collection = DistributionCategoryCollection::fromQueryResults($data);
        return new FullDistributionCategoryDTO(
            $collection,
            $collection->totalMovimientos()
        );
        
    }
    public function getTotalPresupuesto(ReporteQueryDTO $reporteQueryDTO){
        return $this->reporteRepository->getTotalPresupuesto($reporteQueryDTO->startDate, $reporteQueryDTO->endDate);
    }
    public function getTotalGastos(ReporteQueryDTO $reporteQueryDTO){
        return $this->reporteRepository->getTotalGastos($reporteQueryDTO->startDate, $reporteQueryDTO->endDate);
    }

    public function getBalanceNeto(ReporteQueryDTO $reporteQueryDTO){
        return $this->reporteRepository->getBalanceNeto($reporteQueryDTO->startDate, $reporteQueryDTO->endDate);
    }

    public function getIngresos(ReporteQueryDTO $reporteQueryDTO){
        return $this->reporteRepository->getIngresos($reporteQueryDTO->startDate, $reporteQueryDTO->endDate);
    }
    public function getGastos(ReporteQueryDTO $reporteQueryDTO){
        return $this->reporteRepository->getGastos($reporteQueryDTO->startDate, $reporteQueryDTO->endDate);
    }

    protected function getPreviousPeriodKPIs(ReporteQueryDTO $reporteQueryDTO){
        // calcular la diferencia en días de las fechas
        $duration = $reporteQueryDTO->startDate->diffInDays($reporteQueryDTO->endDate);

        $previousStartDate = $reporteQueryDTO->startDate->copy()->subDays($duration + 1);
        $previousEndDate = $reporteQueryDTO->startDate->copy()->subDay();

        return $this->reporteRepository->getKPIs($previousStartDate, $previousEndDate);
    }
}