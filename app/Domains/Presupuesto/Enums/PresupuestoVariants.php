<?php

namespace App\Domains\Presupuesto\Enums;

enum PresupuestoVariants : string {
    case MES_ACTUAL = 'mes_actual';
    case HISTORICO = 'historico';
    case TOTAL = 'total';
}