<?php

namespace App\Domains\Reporte\Services\Application;
// Resources    
use App\Domains\Reporte\Resources\ReporteFormOptionsResource;
use App\Domains\Reporte\Resources\FullReporteResource;
// Services
use App\Domains\Reporte\Services\Domain\ReporteQueryService;
use App\Domains\Reporte\Services\Domain\ReporteFinancialService;
// Strategies / Resolvers
use App\Domains\Reporte\Strategies\Resolvers\Granularity\ReportGranularityResolver;
// Specifications
use App\Domains\Reporte\Specifications\DefaultDateRangeSpecification;
use App\Domains\Reporte\Specifications\CategoriasIdsSpecification;
use App\Domains\Reporte\Specifications\CuentasIdsSpecification;
// DTOs
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Reporte\DTOs\FullReportDTO;
use App\Shared\DTOs\Querys\IdsDTO;
// Value Objects
use App\Domains\Reporte\ValueObjects\DateRange;

class ReporteService{

    public function __construct(
        private ReporteQueryService $reporteQueryService,
        private ReporteFinancialService $reporteFinancialService,
        private ReportGranularityResolver $granularityResolver,

    ){}

    public function getOptions(){
        return ReporteFormOptionsResource::make($this->reporteQueryService->getOptions());
    }


    public function getFullReport(array $data){
        $dto = $this->buildReporteQueryDTO($data);
        $fullReportDTO = new FullReportDTO(
            KPIs: $this->reporteQueryService->getPeriodKPIs($dto),
            ingresos_vs_gastos: $this->reporteQueryService->getIngresosVsGastos($dto),
            distribucion_por_categoria: $this->reporteQueryService->getCategoryDistribution($dto, 1),
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

    private function resolveCuentasIds(array $data){
        return (new CuentasIdsSpecification())->isSatisfiedBy($data) ? IdsDTO::fromArray($data['cuentas']) : null;
    }
    private function resolveCategoriasIds(array $data){
        return (new CategoriasIdsSpecification())->isSatisfiedBy($data) ? IdsDTO::fromArray($data['categorias']) : null;
    }
      private function buildReporteQueryDTO(array $data){
        $dateRange = $this->resolveDateRange($data);
        $cuentas = $this->resolveCuentasIds($data);
        $categorias = $this->resolveCategoriasIds($data);
        $granularity = $this->granularityResolver->resolve($dateRange->diffDays());
        return new ReporteQueryDTO(
        dateRange: $dateRange,
        granularityStrategy: $granularity,
        categorias: $categorias,
        cuentas: $cuentas
        );
        
    }
}