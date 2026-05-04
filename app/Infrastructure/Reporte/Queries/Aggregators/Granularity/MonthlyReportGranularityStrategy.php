<?php

namespace App\Infrastructure\Reporte\Queries\Aggregators\Granularity;

use App\Domains\Reporte\Contracts\Strategies\ReportGranularityStrategyContract;
use App\Infrastructure\Reporte\Queries\Aggregators\Abstracts\ReportGranularityStrategy;

/**
 * Estrategia de granularidad para reportes mensuales
 * Agrupa los datos por mes
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
class MonthlyReportGranularityStrategy extends ReportGranularityStrategy implements ReportGranularityStrategyContract{
    protected int $limit = 365;
    public function groupBy(): string
    {
        return 'DATE_FORMAT(fecha, "%Y-%m")';
    }

}