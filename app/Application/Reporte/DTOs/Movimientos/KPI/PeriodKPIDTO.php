<?php

namespace App\Application\Reporte\DTOs\Movimientos\KPI;
/**
 * DTO que representa un periodo de tiempo de key perfomance indicators con sus totales y variaciones.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Reporte\DTOs\Movimientos\KPI
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class PeriodKPIDTO {
    public function __construct(
        public TotalsKPIDTO $totales,
        public VariationsKPIDTO $variaciones
    )
    {
    }

}
