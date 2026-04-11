<?php

namespace App\Domains\Reporte\ValueObjects\Ingresos;

final class IngresoVO
{
    public function __construct(
        public string $fecha,
        public float $monto
    ) {
    }
}
