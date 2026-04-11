<?php

namespace App\Domains\Reporte\Enums;

use App\Shared\Domain\Contracts\Reporte\ReporteQueryTypeContract;

enum PresupuestoReporteQueryType: string implements ReporteQueryTypeContract
{
    case TOTAL_PRESUPUESTO = 'total_presupuesto';
    // Future: case DISTRIBUCION = 'distribucion';
}