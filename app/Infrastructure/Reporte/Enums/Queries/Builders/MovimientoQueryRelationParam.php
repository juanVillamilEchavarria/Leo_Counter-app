<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Enums\Queries\Builders;

use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;

enum MovimientoQueryRelationParam: string implements QueryRelationParamContract
{
    case TABLE     = 'movimientos';
    case CATEGORIAS_JOIN       = 'categorias_join';
    case TIPO_MOVIMIENTOS_JOIN = 'tipo_movimientos_join';
    case ONLY_FIXED_JOIN       = 'only_fixed_join';
}