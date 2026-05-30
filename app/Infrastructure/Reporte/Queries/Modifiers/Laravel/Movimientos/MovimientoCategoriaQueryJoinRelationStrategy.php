<?php

namespace App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos;

use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;
use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Abstracts\QueryJoinRelationStrategy;
use App\Shared\Domain\Enums\ComparativeOperators;

final class MovimientoCategoriaQueryJoinRelationStrategy extends QueryJoinRelationStrategy
{
    protected string $table = MovimientoQueryRelationParam::TABLE->value;
        protected string $relationTable = 'categorias';
        protected string $relationColumn = 'movimientos.categoria_id';
        protected string $comparativeColumn = 'categorias.id';
        protected ComparativeOperators $joinOperator = ComparativeOperators::EQUALS;

    protected function dtoProperty(ReporteQuery $reporteQueryDTO): mixed
    {
        return null;
    }

    public function supports(ReporteQuery $reporteQueryDTO, QueryRelationParamContract $param): bool
    {
        return $param->value === MovimientoQueryRelationParam::CATEGORIAS_JOIN->value;
    }
}
