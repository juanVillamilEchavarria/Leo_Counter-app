<?php

namespace App\Infrastructure\Reporte\Queries\Aggregators\Granularity;

use App\Domains\Reporte\Contracts\Strategies\ReportGranularityStrategyContract;

use App\Infrastructure\Reporte\Queries\Aggregators\Abstracts\ReportGranularityStrategy;

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