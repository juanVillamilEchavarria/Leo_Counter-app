<?php

namespace App\Domains\Reporte\ValueObjects;

final class PromedioVO
{
    public function __construct(
        public ?float $ingresos_por_periodo,
        public ?float $gastos_por_periodo,
        public ?float $ingresos_por_movimiento,
        public ?float $gastos_por_movimiento
    ) {
    }
}
