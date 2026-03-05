<?php

namespace App\Domains\Reporte\Services\Application;
use App\Domains\Reporte\Services\Domain\ReporteQueryService;
use App\Domains\Reporte\Services\Domain\ReporteFinancialService;

use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Reporte\DTOs\FullReportDTO;
use App\Domains\Reporte\Resources\FullReporteResource;

class ReporteService{

    public function __construct(
        private ReporteQueryService $reporteQueryService,
        private ReporteFinancialService $reporteFinancialService
    ){}

    public function getFullReport(array $data){
        $dto = ReporteQueryDTO::fromArray($data);
        $fullReportDTO = new FullReportDTO(
            KPIs: $this->reporteQueryService->getPeriodKPIs($dto),
            ingresos_vs_gastos: $this->reporteQueryService->getIngresosVsGastos($dto),
            distribucion_por_categoria: $this->reporteQueryService->getDistributionByCategory($dto, 1),
            balance_neto: $this->reporteQueryService->getBalanceNeto($dto),
            presupuesto: $this->reporteFinancialService->getUsedBudget($dto)
        );
        return FullReporteResource::make($fullReportDTO);
    }
    public function getPeriodKPIs(array $data){
        $dto = ReporteQueryDTO::fromArray($data);
        return $this->reporteQueryService->getPeriodKPIs($dto);
    }
}