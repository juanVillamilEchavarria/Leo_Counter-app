<?php

namespace App\Application\Reporte\Projections;

use App\Domains\Reporte\Collections\FinancialPeriodCollection;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\ValueObjects\PromedioVO;
use App\Domains\Reporte\ValueObjects\IngresosVsGastosVO;
final class IngresosVsGastosProjection
{
    public function assemble(FinancialPeriodCollection $queryResults): IngresosVsGastosVO
    {
        $promedioVO = new PromedioVO(
            ingresos_por_periodo: $queryResults->ingresosPeriodAverage(),
            gastos_por_periodo: $queryResults->gastosPeriodAverage(),
            ingresos_por_movimiento: $queryResults->ingresosIndividualAverage(),
            gastos_por_movimiento: $queryResults->gastosIndividualAverage()
        );

        return new IngresosVsGastosVO(
            data: $queryResults,
            promedios: $promedioVO
        );
    }
}
