<?php

namespace App\Domains\Reporte\ValueObjects\KPI;

use App\Domains\Reporte\ValueObjects\Financial\FinancialReportVO;

final class KPIVO extends FinancialReportVO
{
    public function __construct(
        float $ingresos,
        float $gastos,
        public int $total_movimientos
    ) {
        parent::__construct($ingresos, $gastos);
    }
}
