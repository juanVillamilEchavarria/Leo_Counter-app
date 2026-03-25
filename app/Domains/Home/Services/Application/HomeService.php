<?php
namespace App\Domains\Home\Services\Application;

use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Home\DTO\HomeReportDTO;
use App\Domains\Home\Resources\HomeResource;
use App\Domains\Home\Services\Domain\HomeQueryService;
use App\Domains\Reporte\Strategies\Resolvers\Granularity\ReportGranularityResolver;
use App\Domains\Reporte\ValueObjects\DateRange;

class HomeService{
    public function __construct(
        private HomeQueryService $queryService,
        private ReportGranularityResolver $granularityResolver
    )
    {
    }

    public function getReport(){
        $dto = $this->buildDTO();
        $reportDTO = new HomeReportDTO(
            KPIs: $this->queryService->getPeriodKPIs($dto),
            ingresos_vs_gastos: $this->queryService->getIngresosVsGastos($dto)
        );
        return HomeResource::make($reportDTO);
        
    }

    private function buildDTO(): ReporteQueryDTO{
        $dateRange= DateRange::lastMonth();
        $granularity = $this->granularityResolver->resolve($dateRange->diffDays());
        return new ReporteQueryDTO(
            dateRange: $dateRange,
            granularityStrategy: $granularity
        );
    }
}