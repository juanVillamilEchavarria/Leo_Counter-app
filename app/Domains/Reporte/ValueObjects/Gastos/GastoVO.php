<?php

namespace App\Domains\Reporte\ValueObjects\Gastos;

final class GastoVO
{
    public function __construct(
        public string $fecha,
        public float $monto
    ) {
    }
}
