<?php

namespace App\Infrastructure\Reporte\Queries\Aggregators\Granularity;

use App\Domains\Reporte\Contracts\Strategies\ReportGranularityStrategyContract;

use App\Infrastructure\Reporte\Queries\Aggregators\Abstracts\ReportGranularityStrategy;

/**
 * Estrategia de granularidad para reportes anuales
 * Agrupa los datos por año
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
class YearlyReportGranularityStrategy extends ReportGranularityStrategy implements ReportGranularityStrategyContract{
    public function supports(int $days)
    {
        return $days > 365;
    }
    public function groupBy(): string
    {
        return 'DATE(fecha, "%Y")';
    }
}