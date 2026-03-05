<?php
namespace App\Domains\Reporte\DTOs;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Support\Collection;
use App\Domains\Reporte\DTOs\KPI\PeriodKPIDTO;
use App\Domains\Reporte\DTOs\IngresosVsGastos\IngresosVsGastosDTO;
use App\Domains\Reporte\DTOs\Category\FullDistributionCategoryDTO;
use App\Domains\Reporte\DTOs\Budget\UsedBudgetDTO;
class FullReportDTO extends DTO{
    public function __construct(
        public PeriodKPIDTO $KPIs,
        public IngresosVsGastosDTO $ingresos_vs_gastos,
        public FullDistributionCategoryDTO $distribucion_por_categoria,
        public Collection $balance_neto,
        public UsedBudgetDTO $presupuesto
        
    )
    {
    }
}