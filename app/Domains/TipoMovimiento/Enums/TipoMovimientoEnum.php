<?php

namespace App\Domains\TipoMovimiento\Enums;

enum TipoMovimientoEnum: int
{
    case INGRESO = 1;
    case GASTO = 2;
    case TRANSFERENCIA = 3;
}