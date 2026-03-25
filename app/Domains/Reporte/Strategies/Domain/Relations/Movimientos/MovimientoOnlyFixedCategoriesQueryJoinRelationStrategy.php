<?php

namespace App\Domains\Reporte\Strategies\Domain\Relations\Movimientos;

use App\Domains\Reporte\Strategies\Abstracts\QueryJoinRelationStrategy;
use App\Domains\Reporte\Strategies\Contracts\QueryRelationStrategyContract;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use App\Shared\Enums\ComparativeOperators;
use App\Domains\Reporte\Strategies\Enums\QueryRelationParam;
class MovimientoOnlyFixedCategoriesQueryJoinRelationStrategy extends QueryJoinRelationStrategy implements QueryRelationStrategyContract {
    protected string $table = QueryRelationParam::MOVIMIENTOS_TABLE->value;
    protected string $relationTable= QueryRelationParam::CATEGORIAS_TABLE->value;
    protected string $relationColumn = 'movimientos.categoria_id';
    protected string $comparativeColumn = 'categorias.id';
    protected ComparativeOperators $joinOperator = ComparativeOperators::EQUALS; 

    protected function dtoProperty(ReporteQueryDTO $reporteQueryDTO): mixed
    {
        return $reporteQueryDTO->only_categorias_fijas;
    }
    public function supports(ReporteQueryDTO $reporteQueryDTO, QueryRelationParam $table)
    {
        return $this->dtoProperty($reporteQueryDTO)===true && $table->value === $this->table;
    }

    protected function wheres(): ?array
    {
        return [
            new WhereFilterQueryDTO('categorias.es_fijo', ComparativeOperators::EQUALS, true)
        ];
    }
    
}