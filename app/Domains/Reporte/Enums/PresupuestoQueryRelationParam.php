<?php

namespace App\Domains\Reporte\Enums;

use App\Shared\Domain\Contracts\Reporte\QueryRelationParamContract;

enum PresupuestoQueryRelationParam: string implements QueryRelationParamContract
{
    case TABLE           = 'presupuestos';
    case CATEGORIAS_JOIN = 'categorias_join';
}