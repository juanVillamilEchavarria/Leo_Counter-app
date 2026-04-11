<?php

namespace App\Domains\Reporte\ValueObjects\KPI;

final class VariationsKPIVO
{
    public function __construct(
        public ?float $ingresos,
        public ?float $gastos,
        public ?float $balance_neto,
        public ?int $movimientos
    ) {
    }
}
