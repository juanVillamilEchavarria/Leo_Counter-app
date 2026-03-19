<?php

namespace App\Domains\Reporte\Strategies\Domain\Granularity;

use App\Domains\Reporte\Strategies\Contracts\ReportGranularityStrategyContract;
use App\Domains\Reporte\Strategies\Abstracts\ReportGranularityStrategy;

class DailyReportGranularityStrategy extends ReportGranularityStrategy implements ReportGranularityStrategyContract{
    public int $limit = 30;
    public function groupBy(): string{
        return 'DATE(fecha)';
    }
}