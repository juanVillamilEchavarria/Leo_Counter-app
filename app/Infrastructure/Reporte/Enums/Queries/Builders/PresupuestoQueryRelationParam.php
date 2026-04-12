<?php

namespace App\Infrastructure\Reporte\Enums\Queries\Builders;

use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;

enum PresupuestoQueryRelationParam: string implements QueryRelationParamContract
{
    case TABLE           = 'presupuestos';
    case CATEGORIAS_JOIN = 'categorias_join';
}