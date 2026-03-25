<?php

namespace App\Domains\Reporte\Services\Domain;
// Contracts
use App\Domains\Reporte\Repositories\Contracts\ReporteRepositoryContract;
use App\Domains\Categoria\Repositories\Contracts\CategoriaReadRepositoryContract;
use App\Domains\Cuenta\Repositories\Contracts\CuentaReadRepositoryContract;
// Collections
use App\Domains\Reporte\Collections\DistributionCategoryCollection;
// QueryHandlers
use App\Domains\Reporte\QueryHandlers\KPIQueryHandler;
use App\Domains\Reporte\QueryHandlers\IngresoVsGastosQueryHandler;
// DTOs
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Categoria\DTOs\IngresoAndGastoCategoriaDTO;
use App\Domains\Reporte\DTOs\KPI\PeriodKPIDTO;
use App\Domains\Reporte\DTOs\Category\FullDistributionCategoryDTO;
use App\Domains\Reporte\DTOs\Form\ReporteFormOptionsDTO;
//Enums
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;


class ReporteQueryService {
    public function __construct(
        private ReporteRepositoryContract $reporteRepository,
        private KPIQueryHandler $kpiHandler,
        private IngresoVsGastosQueryHandler $ingresoVsGastosHandler,
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
      return $this->kpiHandler->apply($this->reporteRepository,$reporteQueryDTO);
    }

    public function getIngresosVsGastos(ReporteQueryDTO $reporteQueryDTO){
        return $this->ingresoVsGastosHandler->apply($this->reporteRepository,$reporteQueryDTO);
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

}