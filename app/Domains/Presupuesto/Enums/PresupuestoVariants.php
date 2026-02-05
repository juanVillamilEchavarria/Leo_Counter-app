<?php

namespace App\Domains\Presupuesto\Enums;

enum PresupuestoVariants : string {
    case MES_ACTUAL = 'mes_actual';
    case TOTAL = 'total';
}