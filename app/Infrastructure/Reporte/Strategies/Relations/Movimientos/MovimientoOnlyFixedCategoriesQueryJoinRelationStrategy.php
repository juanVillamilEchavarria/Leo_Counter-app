<?php

namespace App\Infrastructure\Reporte\Strategies\Relations\Movimientos;

use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Infrastructure\Reporte\Strategies\Relations\Abstracts\QueryJoinRelationStrategy;
use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use App\Shared\Enums\ComparativeOperators;

final class MovimientoOnlyFixedCategoriesQueryJoinRelationStrategy extends QueryJoinRelationStrategy
{
    public function __construct()
    {
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

    public function supports(ReporteQueryDTO $reporteQueryDTO, QueryRelationParamContract $param): bool
    {
        return $this->dtoProperty($reporteQueryDTO) === true
            && $param->value === MovimientoQueryRelationParam::ONLY_FIXED_JOIN->value;
    }

    protected function wheres(): ?array
    {
        return [
            new WhereFilterQueryDTO('categorias.es_fijo', ComparativeOperators::EQUALS, true),
        ];
    }
}
