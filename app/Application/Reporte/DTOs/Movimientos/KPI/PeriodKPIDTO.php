<?php

namespace App\Application\Reporte\DTOs\Movimientos\KPI;
use App\Shared\Abstracts\DTOs\DTO;
use App\Application\Reporte\DTOs\Movimientos\KPI\VariationsKPIDTO;
use App\Application\Reporte\DTOs\Movimientos\KPI\TotalsKPIDTO;
class PeriodKPIDTO extends DTO{
    public function __construct(
        public TotalsKPIDTO $totales,
        public VariationsKPIDTO $variaciones
    )
    {
    }

}