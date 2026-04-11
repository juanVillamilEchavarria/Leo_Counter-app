<?php

namespace App\Domains\Reporte\ValueObjects\BalanceNeto;

final class BalanceNetoVO
{
    public function __construct(
        public float $balance,
        public string $fecha
    ) {
    }
}
