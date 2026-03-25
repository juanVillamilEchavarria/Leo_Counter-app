<?php

namespace App\Domains\Home\DTO;
use App\Domains\Reporte\DTOs\KPI\PeriodKPIDTO;
use Illuminate\Support\Collection;
use App\Domains\Reporte\DTOs\IngresosVsGastos\IngresosVsGastosDTO;
use App\Shared\Abstracts\DTOs\DTO;

class HomeReportDTO extends DTO{
    public function __construct(
        public PeriodKPIDTO $KPIs,
        public IngresosVsGastosDTO $ingresos_vs_gastos
    )
    {
    }
}
