<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
    case USED_BUDGET = 'used_budget';

    /**
     * Obtiene todos los tipos de estadística disponibles
     */
    public static function fullReport(): array {
        return [self::TOTAL_PRESUPUESTO, self::USED_BUDGET];
    }
    // Future: case DISTRIBUCION = 'distribucion';
}