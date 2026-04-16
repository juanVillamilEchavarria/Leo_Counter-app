<?php
namespace App\Domains\Home\Services;

use App\Application\Reporte\Contracts\Orchestrators\ReporteRepositoryContract;
use App\Application\Reporte\DTOs\ReporteQuery;
use App\Domains\Reporte\QueryHandlers\KPIQueryHandler;
use App\Domains\Reporte\QueryHandlers\IngresoVsGastosQueryHandler;
use App\Application\Reporte\DTOs\Movimientos\KPI\PeriodKPIDTO;

class HomeQueryService{
    public function __construct(
        private ReporteRepositoryContract $reporteRepository,
        private KPIQueryHandler $kpiHandler,
        private IngresoVsGastosQueryHandler $ingresoVsGastosHandler
    )
    {
    }
     public function getPeriodKPIs(ReporteQuery $reporteQueryDTO) : PeriodKPIDTO {
        return $this->kpiHandler->apply($this->reporteRepository,$reporteQueryDTO);
    }
    public function getIngresosVsGastos(ReporteQuery $reporteQueryDTO){
        return $this->ingresoVsGastosHandler->apply($this->reporteRepository,$reporteQueryDTO);
    }
    
}