<?php

namespace App\Application\Reporte\DTOs;

use App\Application\Reporte\DTOs\Category\FullDistributionCategoryDTO;
use App\Application\Reporte\DTOs\IngresosVsGastos\IngresosVsGastosDTO;
use App\Application\Reporte\DTOs\KPI\PeriodKPIDTO;
use App\Shared\Abstracts\DTOs\DTO;

/**
 * DTO de aplicación que representa la respuesta completa del módulo de reportes.
 * Agrupa las métricas ya ensambladas y listas para serialización HTTP.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class FullReportDTO extends DTO
{
    /**
     * @param array<int, array{balance: float, fecha: string}> $balance_neto_por_fecha
     */
    public function __construct(
        public readonly ?PeriodKPIDTO $KPIs,
        public readonly ?IngresosVsGastosDTO $ingresos_vs_gastos,
        public readonly array $balance_neto_por_fecha,
        public readonly ?float $presupuesto,
        public readonly ?FullDistributionCategoryDTO $distribucion_por_categoria,
    ) {
    }
}
