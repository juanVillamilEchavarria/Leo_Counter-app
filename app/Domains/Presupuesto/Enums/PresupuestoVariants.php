<?php

namespace App\Domains\Presupuesto\Enums;

enum PresupuestoVariants : string {
    case MES_ACTUAL = 'mes_actual';
    case POR_PERIODO = 'por_periodo';
    case TOTAL = 'total';
}