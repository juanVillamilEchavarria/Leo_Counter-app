<?php
namespace App\Domains\Reporte\Strategies\Enums;

enum QueryRelationParam: string{
    case MOVIMIENTOS_TABLE = 'movimientos';
    case CATEGORIAS_TABLE = 'categorias';
    case TIPO_MOVIMIENTOS_TABLE = 'tipo_movimientos';
    case PRESUPUESTOS_TABLE = 'presupuestos';
    case CATEGORIAS_JOIN = 'categorias_join';
    case TIPO_MOVIMIENTOS_JOIN = 'tipo_movimientos_join';

}