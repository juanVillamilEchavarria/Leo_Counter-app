<?php

namespace App\Domains\Reporte\Strategies\Domain\Relations\Movimientos;

use App\Domains\Reporte\Strategies\Abstracts\QueryJoinRelationStrategy;
use App\Domains\Reporte\Strategies\Contracts\QueryRelationStrategyContract;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use App\Shared\Enums\ComparativeOperators;
class MovimientoOnlyFixedCategoriesQueryJoinRelationStrategy extends QueryJoinRelationStrategy implements QueryRelationStrategyContract {
    protected string $table = 'movimientos';
    protected string $relationTable= 'categorias';
    protected string $relationColumn = 'movimientos.categoria_id';
    protected string $comparativeColumn = 'categorias.id';
    protected string $dtoProperty = 'only_categorias_fijas';
    protected ComparativeOperators $joinOperator = ComparativeOperators::EQUALS; 

    public function supports(ReporteQueryDTO $reporteQueryDTO, string $table)
    {
        return $reporteQueryDTO->{$this->dtoProperty}===true && $table === $this->table;
    }

    protected function wheres(): ?array
    {
        return [
            new WhereFilterQueryDTO('categorias.es_fijo', ComparativeOperators::EQUALS, true)
        ];
    }
    
}