<?php

namespace App\Domains\Reporte\Services\Domain;
// Contracts
use App\Domains\Reporte\Repositories\Contracts\ReporteRepositoryContract;
use App\Domains\Categoria\Repositories\Contracts\CategoriaReadRepositoryContract;
use App\Domains\Cuenta\Repositories\Contracts\CuentaReadRepositoryContract;
// Collections
use App\Domains\Reporte\Collections\FinancialPeriodCollection;
use App\Domains\Reporte\Collections\DistributionCategoryCollection;
use App\Domains\Reporte\Collections\KPICollection;
// Services
use App\Shared\Services\Financial\PercentageService;
// Value Objects
use App\Domains\Reporte\ValueObjects\DateRange;
// DTOs
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Categoria\DTOs\IngresoAndGastoCategoriaDTO;
use App\Domains\Reporte\DTOs\KPI\PeriodKPIDTO;
use App\Domains\Reporte\DTOs\KPI\TotalsKPIDTO;
use App\Domains\Reporte\DTOs\KPI\VariationsKPIDTO;
use App\Domains\Reporte\DTOs\IngresosVsGastos\IngresosVsGastosDTO;
use App\Domains\Reporte\DTOs\Promedio\PromedioDTO;
use App\Domains\Reporte\DTOs\Category\FullDistributionCategoryDTO;
use App\Domains\Reporte\DTOs\Form\ReporteFormOptionsDTO;
//Enums
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

class ReporteQueryService {
    public function __construct(
        private ReporteRepositoryContract $reporteRepository,
        private PercentageService $percentageService,
        private CategoriaReadRepositoryContract $categoriaReadRepository,
        private CuentaReadRepositoryContract $cuentaReadRepository
    )
    {
    }

    public function getOptions(){
        $categoriasDto= new IngresoAndGastoCategoriaDTO(
            $this->categoriaReadRepository->getForOptionsByTipoMovimiento(TipoMovimientoEnum::INGRESO),
            $this->categoriaReadRepository->getForOptionsByTipoMovimiento(TipoMovimientoEnum::GASTO)
        );
        return new ReporteFormOptionsDTO(
            $categoriasDto,
            $this->cuentaReadRepository->getForOptions()
        );

    }

    public function getPeriodKPIs(ReporteQueryDTO $reporteQueryDTO) : PeriodKPIDTO {
      $data = $this->reporteRepository->getKPIs($reporteQueryDTO);
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
        $data = $this->reporteRepository->getIngresosVsGastos($reporteQueryDTO);
        $collection = FinancialPeriodCollection::fromQueryResults($data);
        $promedioDTO = new PromedioDTO(
            ingresos_por_periodo:$collection->ingresosPeriodAverage(),
            gastos_por_periodo:$collection->gastosPeriodAverage(),
            ingresos_por_movimiento:$collection->ingresosIndividualAverage(),
            gastos_por_movimiento:$collection->gastosIndividualAverage()
        );
        return new IngresosVsGastosDTO(
            $collection,
            $promedioDTO
        );
    }

    public function getCategoryDistribution(ReporteQueryDTO $reporteQueryDTO, int $tipo_movimiento_id): FullDistributionCategoryDTO{
        $data = $this->reporteRepository->getCategoryDistribution($reporteQueryDTO, $tipo_movimiento_id);
        $collection = DistributionCategoryCollection::fromQueryResults($data);
        return new FullDistributionCategoryDTO(
            $collection,
            $collection->totalMovimientos()
        );
        
    }
    public function getTotalPresupuesto(ReporteQueryDTO $reporteQueryDTO){
        return $this->reporteRepository->getTotalPresupuesto($reporteQueryDTO);
    }
    public function getTotalGastos(ReporteQueryDTO $reporteQueryDTO){
        return $this->reporteRepository->getTotalGastos($reporteQueryDTO);
    }

    public function getBalanceNeto(ReporteQueryDTO $reporteQueryDTO){
        return $this->reporteRepository->getBalanceNeto($reporteQueryDTO);
    }

    public function getIngresos(ReporteQueryDTO $reporteQueryDTO){
        return $this->reporteRepository->getIngresos($reporteQueryDTO);
    }
    public function getGastos(ReporteQueryDTO $reporteQueryDTO){
        return $this->reporteRepository->getGastos($reporteQueryDTO);
    }

    protected function getPreviousPeriodKPIs(ReporteQueryDTO $reporteQueryDTO){
        // calcular la diferencia en días de las fechas
        $duration = $reporteQueryDTO->dateRange->startDate->diffInDays($reporteQueryDTO->dateRange->endDate);

        $previousStartDate = $reporteQueryDTO->dateRange->startDate->copy()->subDays($duration + 1);
        $previousEndDate = $reporteQueryDTO->dateRange->startDate->copy()->subDay();
        $dateRange = new DateRange($previousStartDate, $previousEndDate);

        $prevouisReporteQueryDTO = new ReporteQueryDTO(
            $reporteQueryDTO->granularityStrategy,
            $dateRange
        );
        return $this->reporteRepository->getKPIs($prevouisReporteQueryDTO);
    }
}