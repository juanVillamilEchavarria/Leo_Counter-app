<?php

namespace App\Infrastructure\Reporte\Strategies\Relations\Abstracts;

use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Infrastructure\Reporte\Contracts\Queries\ReporteQueryRelationStrategyContract;
use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;
use App\Shared\DTOs\Querys\IdsDTO;
use App\Shared\Infrastructure\QueryBuilders\DomainQueryBuilder;

/**
 * Estrategia base de infraestructura para aplicar filtros `whereIn`
 * sobre columnas de relación a partir de identificadores del DTO de consulta.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
abstract class QueryIdRelationStrategy implements ReporteQueryRelationStrategyContract
{
    protected string $table;
    protected string $relationColumn;

    abstract protected function dtoProperty(ReporteQueryDTO $reporteQueryDTO): ?IdsDTO;

    public function supports(ReporteQueryDTO $reporteQueryDTO, QueryRelationParamContract $param): bool
    {
        return $this->dtoProperty($reporteQueryDTO) !== null && $this->table === $param->value;
    }

    public function apply(DomainQueryBuilder $query, ReporteQueryDTO $reporteQueryDTO): DomainQueryBuilder
    {
        $ids = $this->dtoProperty($reporteQueryDTO);

        return $query->whereIn($this->relationColumn, $ids?->toArray()['ids'] ?? []);
    }
}
