<?php

namespace App\Domains\Reporte\Enums;

enum ReporteRepositoryType: string
{
    case MOVIMIENTOS  = 'movimientos';
    case PRESUPUESTOS = 'presupuestos';
    // Future: case CUENTAS = 'cuentas';
}