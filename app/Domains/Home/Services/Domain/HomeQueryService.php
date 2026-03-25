<?php
namespace App\Domains\Home\Services\Domain;

use App\Domains\Reporte\Repositories\Contracts\ReporteRepositoryContract;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Reporte\QueryHandlers\KPIQueryHandler;
use App\Domains\Reporte\QueryHandlers\IngresoVsGastosQueryHandler;
use App\Domains\Reporte\DTOs\KPI\PeriodKPIDTO;

class HomeQueryService{
    public function __construct(
        private ReporteRepositoryContract $reporteRepository,
        private KPIQueryHandler $kpiHandler,
        private IngresoVsGastosQueryHandler $ingresoVsGastosHandler
    )
    {
    }
     public function getPeriodKPIs(ReporteQueryDTO $reporteQueryDTO) : PeriodKPIDTO {
        return $this->kpiHandler->apply($this->reporteRepository,$reporteQueryDTO);
    }
    public function getIngresosVsGastos(ReporteQueryDTO $reporteQueryDTO){
        return $this->ingresoVsGastosHandler->apply($this->reporteRepository,$reporteQueryDTO);
    }
    
}