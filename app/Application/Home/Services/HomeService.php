<?php
namespace App\Application\Home\Services;

use App\Application\Reporte\DTOs\ReporteQuery;
use App\Domains\Home\DTO\HomeReportDTO;
use App\Http\Resources\Home\HomeResource;
use App\Domains\Home\Services\HomeQueryService;
use App\Application\Reporte\Resolvers\Granularity\ReportGranularityResolver;
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

    private function buildDTO(): ReporteQuery{
        $dateRange= DateRange::lastMonth();
        $granularity = $this->granularityResolver->resolve($dateRange->diffDays());
        return new ReporteQuery(
            dateRange: $dateRange,
            granularityStrategy: $granularity
        );
    }
}