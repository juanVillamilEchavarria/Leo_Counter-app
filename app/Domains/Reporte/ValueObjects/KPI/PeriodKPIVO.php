<?php

namespace App\Domains\Reporte\ValueObjects\KPI;

use App\Domains\Reporte\ValueObjects\PromedioVO;

final class PeriodKPIVO
{
    public function __construct(
        public TotalsKPIVO $totales,
        public VariationsKPIVO $variaciones
    ) {
    }
}
