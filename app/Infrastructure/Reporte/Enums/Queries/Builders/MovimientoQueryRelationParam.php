<?php

namespace App\Infrastructure\Reporte\Enums\Queries\Builders;

use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;

enum MovimientoQueryRelationParam: string implements QueryRelationParamContract
{
    case TABLE     = 'movimientos';
    case CATEGORIAS_JOIN       = 'categorias_join';
    case TIPO_MOVIMIENTOS_JOIN = 'tipo_movimientos_join';
    case ONLY_FIXED_JOIN       = 'only_fixed_join';
}