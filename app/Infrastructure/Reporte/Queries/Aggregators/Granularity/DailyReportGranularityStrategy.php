<?php

namespace App\Infrastructure\Reporte\Queries\Aggregators\Granularity;

use App\Domains\Reporte\Contracts\Strategies\ReportGranularityStrategyContract;
use App\Infrastructure\Reporte\Queries\Aggregators\Abstracts\ReportGranularityStrategy;

class DailyReportGranularityStrategy extends ReportGranularityStrategy implements ReportGranularityStrategyContract{
    public int $limit = 30;
    public function groupBy(): string{
        return 'DATE(fecha)';
    }
}