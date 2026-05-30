<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Home\Enums;

use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

/**
 * Enum encargado de definir las estadisticas que se mostraran en el dashboard de home.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
enum HomeStatisticsType : string implements ReportStatisticTypeContract{
    /**
     * Devuelve las estadisticas que se mostraran en el dashboard de home
     * @return array
     */
    public static function statistics() : array{
        return [
            MovimientoReportStatisticType::KPIS,
            MovimientoReportStatisticType::INGRESOS_VS_GASTOS
        ];
    }
}