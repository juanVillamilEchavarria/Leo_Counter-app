<?php

namespace App\Infrastructure\Reporte\Queries\Aggregators\Granularity;

use App\Domains\Reporte\Contracts\Strategies\ReportGranularityStrategyContract;
use App\Infrastructure\Reporte\Queries\Aggregators\Abstracts\ReportGranularityStrategy;

class MonthlyReportGranularityStrategy extends ReportGranularityStrategy implements ReportGranularityStrategyContract{
    public int $limit = 365;
    public function groupBy(): string
    {
        return 'DATE_FORMAT(fecha, "%Y-%m")';
    }

}