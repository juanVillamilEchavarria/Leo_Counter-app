<?php

namespace App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Presupuestos;

use App\Infrastructure\Reporte\Enums\Queries\Builders\PresupuestoQueryRelationParam;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Abstracts\QueryJoinRelationStrategy;
use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use App\Shared\Enums\ComparativeOperators;

final class PresupuestoOnlyFixedCategoriesQueryRelationStrategy extends QueryJoinRelationStrategy
{
    public function __construct()
    {
        $this->table = PresupuestoQueryRelationParam::TABLE->value;
        $this->relationTable = 'categorias';
        $this->relationColumn = 'presupuestos.categoria_id';
        $this->comparativeColumn = 'categorias.id';
        $this->joinOperator = ComparativeOperators::EQUALS;
    }

    protected function dtoProperty(ReporteQuery $reporteQueryDTO): mixed
    {
        return $reporteQueryDTO->only_categorias_fijas;
    }

    public function supports(ReporteQuery $reporteQueryDTO, QueryRelationParamContract $param): bool
    {
        return $this->dtoProperty($reporteQueryDTO) === true
            && $param->value === $this->table;
    }

    protected function wheres(): ?array
    {
        return [
            new WhereFilterQueryDTO('categorias.es_fijo', ComparativeOperators::EQUALS, true),
        ];
    }
}
