<?php

namespace App\Domains\Reporte\Services\Application;
use App\Domains\Reporte\Services\Domain\ReporteQueryService;

use App\Domains\Reporte\DTOs\ReporteQueryDTO;

class ReporteService{

    public function __construct(
        private ReporteQueryService $reporteQueryService
    ){}

    public function getFullReport(array $data){
        $dto = ReporteQueryDTO::fromArray($data);
        return [
            'KIPs'=> $this->reporteQueryService->getPeriodKPIs($dto),
            'ingreso_vs_gastos'=> $this->reporteQueryService->getIngresosVsGastos($dto),
            'distribucion_por_categoria'=> $this->reporteQueryService->getDistributionByCategory($dto, 1),
            'balance_neto'=> $this->reporteQueryService->getBalanceNeto($dto)
        ];
    }
    public function getPeriodKPIs(array $data){
        $dto = ReporteQueryDTO::fromArray($data);
        return $this->reporteQueryService->getPeriodKPIs($dto);
    }
}