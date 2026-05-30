<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Presupuestos;

use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;
use App\Infrastructure\Reporte\Enums\Queries\Builders\PresupuestoQueryRelationParam;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Abstracts\QueryJoinRelationStrategy;
use App\Shared\Domain\Enums\ComparativeOperators;
use App\Shared\Domain\ValueObjects\WhereFilterQueryDTO;

final class PresupuestoOnlyFixedCategoriesQueryRelationStrategy extends QueryJoinRelationStrategy
{
     protected string $table = PresupuestoQueryRelationParam::TABLE->value;
        protected string $relationTable = 'categorias';
        protected string $relationColumn = 'presupuestos.categoria_id';
        protected string $comparativeColumn = 'categorias.id';
        protected ComparativeOperators $joinOperator = ComparativeOperators::EQUALS;

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
