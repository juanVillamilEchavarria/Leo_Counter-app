<?php

namespace App\Domains\Reporte\Enums;

use App\Shared\Domain\Contracts\Reporte\ReporteQueryTypeContract;

enum MovimientoReporteQueryType: string implements ReporteQueryTypeContract
{
    case KPIS                  = 'kpis';
    case BALANCE_NETO          = 'balance_neto';
    case INGRESOS_VS_GASTOS    = 'ingresos_vs_gastos';
    case CATEGORY_DISTRIBUTION = 'category_distribution';
    case INGRESOS              = 'ingresos';
    case GASTOS                = 'gastos';

    /** Types shown in the full report page */
    public static function fullReport(): array
    {
        return [self::KPIS, self::INGRESOS_VS_GASTOS, self::CATEGORY_DISTRIBUTION, self::BALANCE_NETO];
    }

    /** Types shown in the home dashboard */
    public static function homeDashboard(): array
    {
        return [self::KPIS, self::INGRESOS_VS_GASTOS];
    }
}