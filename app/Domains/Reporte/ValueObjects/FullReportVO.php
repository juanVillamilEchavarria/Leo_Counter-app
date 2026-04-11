<?php

namespace App\Domains\Reporte\ValueObjects;

use App\Domains\Reporte\ValueObjects\Category\FullDistributionCategoryVO;
use App\Domains\Reporte\ValueObjects\Budget\UsedBudgetVO;
use App\Domains\Reporte\ValueObjects\KPI\PeriodKPIVO;
use App\Domains\Reporte\ValueObjects\IngresosVsGastosVO;
use App\Domains\Reporte\Collections\BalanceNetoCollection;

final class FullReportVO
{
    public function __construct(
        public PeriodKPIVO $KPIs,
        public IngresosVsGastosVO $ingresos_vs_gastos,
        public FullDistributionCategoryVO $distribucion_por_categoria,
        public BalanceNetoCollection $balance_neto,
        public UsedBudgetVO $presupuesto
    ) {
    }
}
