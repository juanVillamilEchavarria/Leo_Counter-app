<?php

namespace App\Domains\Reporte\Services\Application;
use App\Domains\Reporte\Services\Domain\ReporteQueryService;
use App\Domains\Reporte\Services\Domain\ReporteFinancialService;

use App\Domains\Reporte\Strategies\Resolvers\ReportGranularityResolver;
use App\Domains\Reporte\Specifications\DefaultDateRangeSpecification;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Reporte\DTOs\FullReportDTO;
use App\Domains\Reporte\Resources\FullReporteResource;
use App\Domains\Reporte\ValueObjects\DateRange;

class ReporteService{

    public function __construct(
        private ReporteQueryService $reporteQueryService,
        private ReporteFinancialService $reporteFinancialService,
        private ReportGranularityResolver $granularityResolver
    ){}


    public function getFullReport(array $data){
        $dto = $this->buildReporteQueryDTO($data);
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
        $dto = $this->buildReporteQueryDTO($data);
        return $this->reporteQueryService->getPeriodKPIs($dto);
    }
     private function resolveDateRange(array $data){
        return (new DefaultDateRangeSpecification())->isSatisfiedBy($data) ? DateRange::lastSixMonths() : DateRange::fromArray($data);
    }
      private function buildReporteQueryDTO(array $data){
        $dateRange = $this->resolveDateRange($data);
        $granularity = $this->granularityResolver->resolve($dateRange->diffDays());
        return new ReporteQueryDTO(
        dateRange: $dateRange,
        granularityStrategy: $granularity
        );
        
    }
}