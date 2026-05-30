<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Queries\Aggregators\Granularity;

use App\Domains\Reporte\Contracts\Strategies\ReportGranularityStrategyContract;
use App\Infrastructure\Reporte\Queries\Aggregators\Abstracts\ReportGranularityStrategy;

/**
 * Estrategia de granularidad para reportes diarios
 * Agrupa los datos por día
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
class DailyReportGranularityStrategy extends ReportGranularityStrategy implements ReportGranularityStrategyContract{
    protected int $limit = 30;
    public function groupBy(): string{
        return 'DATE_FORMAT(fecha, "%Y-%m-%d")';
    }
}