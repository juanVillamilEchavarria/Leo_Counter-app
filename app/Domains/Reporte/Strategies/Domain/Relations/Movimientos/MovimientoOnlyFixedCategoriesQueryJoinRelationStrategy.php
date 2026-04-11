<?php

namespace App\Domains\Reporte\Strategies\Domain\Relations\Movimientos;

use App\Domains\Reporte\Strategies\Abstracts\QueryJoinRelationStrategy;
use App\Domains\Reporte\Contracts\Strategies\QueryRelationStrategyContract;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use App\Shared\Enums\ComparativeOperators;
use App\Domains\Reporte\Enums\MovimientoQueryRelationParam;

class MovimientoOnlyFixedCategoriesQueryJoinRelationStrategy extends QueryJoinRelationStrategy implements QueryRelationStrategyContract {
    public function __construct() {
        $this->table = MovimientoQueryRelationParam::TABLE->value;
        $this->relationTable = 'categorias';
        $this->relationColumn = 'movimientos.categoria_id';
        $this->comparativeColumn = 'categorias.id';
        $this->joinOperator = ComparativeOperators::EQUALS;
    }

    protected function dtoProperty(ReporteQueryDTO $reporteQueryDTO): mixed
    {
        return $reporteQueryDTO->only_categorias_fijas;
    }

    public function supports(ReporteQueryDTO $reporteQueryDTO, \App\Shared\Domain\Contracts\Reporte\QueryRelationParamContract $param)
    {
        return $this->dtoProperty($reporteQueryDTO)===true && $param->value === MovimientoQueryRelationParam::ONLY_FIXED_JOIN->value;
    }

    protected function wheres(): ?array
    {
        return [
            new WhereFilterQueryDTO('categorias.es_fijo', ComparativeOperators::EQUALS, true)
        ];
    }
    
}