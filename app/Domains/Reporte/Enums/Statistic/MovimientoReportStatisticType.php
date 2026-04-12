<?php

namespace App\Domains\Reporte\Enums\Statistic;

use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

/**
 * Enum para los tipos de estadísticas de reporte de Movimientos
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 */
enum MovimientoReportStatisticType: string implements ReportStatisticTypeContract
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

    /**
     * Determina si este tipo de estadística requiere consultar el periodo anterior
     * para generar datos comparativos.
     *
     * @return bool
     */
    public function requiresComparativeData(): bool
    {
        return match ($this) {
            self::KPIS => true,
            default => false,
        };
    }

    /**
     * Retorna los tipos del enum que requieren datos comparativos.
     *
     * @return array<int, self>
     */
    public static function withComparativeData(): array
    {
        return array_values(array_filter(
            self::cases(),
            static fn(self $type): bool => $type->requiresComparativeData()
        ));
    }
}
