<?php

namespace App\Infrastructure\Reporte\Strategies\Relations\Abstracts;

use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Infrastructure\Reporte\Contracts\Queries\ReporteQueryRelationStrategyContract;
use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;
use App\Shared\DTOs\Querys\WhereFilterQueryDTO;
use App\Shared\Enums\ComparativeOperators;
use App\Shared\Infrastructure\QueryBuilders\DomainQueryBuilder;

/**
 * Estrategia base de infraestructura para aplicar joins y filtros relacionados
 * sobre consultas Eloquent de reportes.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
abstract class QueryJoinRelationStrategy implements ReporteQueryRelationStrategyContract
{
    protected string $table;
    protected string $relationTable;
    protected string $relationColumn;
    protected string $comparativeColumn = 'id';
    protected ComparativeOperators $joinOperator = ComparativeOperators::EQUALS;

    abstract protected function dtoProperty(ReporteQueryDTO $reporteQueryDTO): mixed;

    public function supports(ReporteQueryDTO $reporteQueryDTO, QueryRelationParamContract $param): bool
    {
        return $this->dtoProperty($reporteQueryDTO) !== null && $this->table === $param->value;
    }

    public function apply(DomainQueryBuilder $query, ReporteQueryDTO $reporteQueryDTO): DomainQueryBuilder
    {
        if (!$query->hasJoin($this->relationTable)) {
            $query = $query->join(
                $this->relationTable,
                $this->relationColumn,
                $this->joinOperator->value,
                $this->comparativeColumn
            );
        }

        foreach ($this->wheres() ?? [] as $where) {
            $query->where($where->column, $where->operator->value, $where->value, $where->logic);
        }

        return $query;
    }

    /**
     * @return array<int, WhereFilterQueryDTO>|null
     */
    protected function wheres(): ?array
    {
        return null;
    }
}
