<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos;

use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;
use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Abstracts\QueryJoinRelationStrategy;
use App\Shared\Domain\Enums\ComparativeOperators;

final class MovimientoTipoMovimientoQueryJoinRelationStrategy extends QueryJoinRelationStrategy
{
     protected string $table = MovimientoQueryRelationParam::TABLE->value;
        protected string $relationTable = 'tipo_movimientos';
        protected string $relationColumn = 'movimientos.tipo_movimiento_id';
        protected string $comparativeColumn = 'tipo_movimientos.id';
        protected ComparativeOperators $joinOperator = ComparativeOperators::EQUALS;

    protected function dtoProperty(ReporteQuery $reporteQueryDTO): mixed
    {
        return null;
    }

    public function supports(ReporteQuery $reporteQueryDTO, QueryRelationParamContract $param): bool
    {
        return $param->value === MovimientoQueryRelationParam::TIPO_MOVIMIENTOS_JOIN->value;
    }
}
