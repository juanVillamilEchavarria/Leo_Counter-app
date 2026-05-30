<?php

namespace App\Application\Reporte\DTOs\Movimientos\KPI;

/**
 * DTO que representa los totales de key perfomance indicators.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Reporte\DTOs\Movimientos\KPI
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class TotalsKPIDTO {

    public function __construct(
        public float $ingresos,
        public float $gastos,
        public float $balance_neto,
        public int $movimientos,
    )
    {
    }
}
