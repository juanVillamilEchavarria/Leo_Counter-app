<?php

namespace App\Domains\Reporte\DTOs\KPI;
use App\Shared\Abstracts\DTOs\DTO;
use App\Domains\Reporte\DTOs\KPI\VariationsKPIDTO;
use App\Domains\Reporte\DTOs\KPI\TotalsKPIDTO;
class PeriodKPIDTO extends DTO{
    public function __construct(
        public TotalsKPIDTO $totales,
        public VariationsKPIDTO $variaciones
    )
    {
    }

}