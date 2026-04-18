<?php
namespace App\Domains\Home\Services;

use App\Application\Reporte\Contracts\Orchestrators\ReporteRepositoryContract;
use App\Application\Reporte\Queries\ReporteQuery;
use App\Domains\Reporte\QueryExecutors\KPIQueryExecutor;
use App\Domains\Reporte\QueryExecutors\IngresoVsGastosQueryExecutor;
use App\Application\Reporte\Queries\Movimientos\KPI\PeriodKPIDTO;

class HomeQueryService{
    public function __construct(
        private ReporteRepositoryContract $reporteRepository,
        private KPIQueryExecutor $kpiHandler,
        private IngresoVsGastosQueryExecutor $ingresoVsGastosHandler
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