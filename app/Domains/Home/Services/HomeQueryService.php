<?php
namespace App\Domains\Home\Services;

use App\Domains\Reporte\Contracts\Ports\ReporteRepositoryContract;
use App\Application\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Reporte\QueryHandlers\KPIQueryHandler;
use App\Domains\Reporte\QueryHandlers\IngresoVsGastosQueryHandler;
use App\Application\Reporte\DTOs\KPI\PeriodKPIDTO;

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