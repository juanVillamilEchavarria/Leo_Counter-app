<?php

namespace App\Domains\Reporte\Strategies\Domain\Relations\Movimientos;

use App\Domains\Reporte\Strategies\Abstracts\QueryJoinRelationStrategy;
use App\Domains\Reporte\Strategies\Contracts\QueryRelationStrategyContract;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Shared\Enums\ComparativeOperators;
use App\Domains\Reporte\Strategies\Enums\QueryRelationParam;

class MovimientoCategoriaQueryJoinRelationStrategy extends QueryJoinRelationStrategy implements QueryRelationStrategyContract{
    protected string $table = QueryRelationParam::MOVIMIENTOS_TABLE->value;
    protected string $relationTable = QueryRelationParam::CATEGORIAS_TABLE->value;
    protected string $relationColumn = 'movimientos.categoria_id';
    protected string $comparativeColumn = 'categorias.id';
    protected ComparativeOperators $joinOperator = ComparativeOperators::EQUALS;

    protected function dtoProperty(ReporteQueryDTO $reporteQueryDTO): mixed{
        return null;
    }
    public function supports(ReporteQueryDTO $reporteQueryDTO, QueryRelationParam $param)
    {
        /**
         * en este caso, se va a comparar con la tabla de la relacion, ya que movimientos tiene varios strategies
         */
        return $param->value === QueryRelationParam::CATEGORIAS_JOIN->value;
    }
}