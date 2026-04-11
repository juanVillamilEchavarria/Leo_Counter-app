<?php

namespace App\Domains\Reporte\Enums;

use App\Shared\Domain\Contracts\Reporte\QueryRelationParamContract;

enum MovimientoQueryRelationParam: string implements QueryRelationParamContract
{
    case TABLE     = 'movimientos';
    case CATEGORIAS_JOIN       = 'categorias_join';
    case TIPO_MOVIMIENTOS_JOIN = 'tipo_movimientos_join';
    case ONLY_FIXED_JOIN       = 'only_fixed_join';
}