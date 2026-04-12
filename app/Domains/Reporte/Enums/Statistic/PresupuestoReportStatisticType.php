<?php

namespace App\Domains\Reporte\Enums\Statistic;

use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;


/**
 * Enum para los tipos de estadísticas permitidas de reporte de Presupuestos
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 */
enum PresupuestoReportStatisticType: string implements ReportStatisticTypeContract
{
    case TOTAL_PRESUPUESTO = 'total_presupuesto';
    // Future: case DISTRIBUCION = 'distribucion';
}