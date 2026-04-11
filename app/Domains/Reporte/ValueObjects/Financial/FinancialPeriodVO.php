<?php

namespace App\Domains\Reporte\ValueObjects\Financial;

final class FinancialPeriodVO extends FinancialReportVO
{
    public function __construct(
        public string $period,
        float $ingresos,
        float $gastos,
        public int $count_ingresos,
        public int $count_gastos
    ) {
        parent::__construct($ingresos, $gastos);
    }
}
