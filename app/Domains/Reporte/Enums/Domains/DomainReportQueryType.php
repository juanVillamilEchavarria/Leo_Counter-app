<?php

namespace App\Domains\Reporte\Enums\Domains;

enum DomainReportQueryType: string
{
    case MOVIMIENTOS  = 'movimientos';
    case PRESUPUESTOS = 'presupuestos';
    // Future: case CUENTAS = 'cuentas';
}