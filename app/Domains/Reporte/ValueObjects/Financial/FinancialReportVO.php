<?php

namespace App\Domains\Reporte\ValueObjects\Financial;

abstract class FinancialReportVO
{
    public function __construct(
        public float $ingresos,
        public float $gastos
    ) {
    }

    public function getBalance(): float
    {
        return $this->ingresos - $this->gastos;
    }
}
