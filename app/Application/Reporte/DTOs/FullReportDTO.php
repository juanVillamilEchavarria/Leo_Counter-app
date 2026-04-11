<?php
namespace App\Application\Reporte\DTOs;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Support\Collection;
use App\Application\Reporte\DTOs\KPI\PeriodKPIDTO;
use App\Application\Reporte\DTOs\IngresosVsGastos\IngresosVsGastosDTO;
use App\Application\Reporte\DTOs\Category\FullDistributionCategoryDTO;
use App\Application\Reporte\DTOs\Budget\UsedBudgetDTO;
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