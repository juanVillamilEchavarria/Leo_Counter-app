<?php

namespace App\Domains\Reporte\Strategies\Domain\Granularity;

use App\Domains\Reporte\Strategies\Contracts\ReportGranularityStrategyContract;

use App\Domains\Reporte\Strategies\Abstracts\ReportGranularityStrategy;

class YearlyReportGranularityStrategy extends ReportGranularityStrategy implements ReportGranularityStrategyContract{
    public function supports(int $days)
    {
        return $days > 365;
    }
    public function groupBy(): string
    {
        return 'DATE_FORMAT(fecha, "%Y")';
    }
}