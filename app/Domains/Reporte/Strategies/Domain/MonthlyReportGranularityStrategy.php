<?php

namespace App\Domains\Reporte\Strategies\Domain;

use App\Domains\Reporte\Strategies\Contracts\ReportGranularityStrategyContract;
use App\Domains\Reporte\Strategies\Abstracts\ReportGranularityStrategy;

class MonthlyReportGranularityStrategy extends ReportGranularityStrategy implements ReportGranularityStrategyContract{
    public int $limit = 365;
    public function groupBy(): string
    {
        return 'DATE_FORMAT(fecha, "%Y-%m")';
    }

}