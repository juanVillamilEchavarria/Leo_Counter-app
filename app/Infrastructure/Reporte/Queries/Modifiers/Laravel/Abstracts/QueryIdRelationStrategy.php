<?php

namespace App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Abstracts;

use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Contracts\Queries\ReporteQueryRelationStrategyContract;
use App\Infrastructure\Reporte\Contracts\Enums\QueryRelationParamContract;
use App\Shared\Domain\ValueObjects\Ids;
use Illuminate\Database\Query\Builder;

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

    abstract protected function dtoProperty(ReporteQuery $reporteQueryDTO): ?Ids;

    public function supports(ReporteQuery $reporteQueryDTO, QueryRelationParamContract $param): bool
    {
        return $this->dtoProperty($reporteQueryDTO) !== null && $this->table === $param->value;
    }

    public function apply(Builder $query, ReporteQuery $reporteQueryDTO): Builder
    {
        /** @var Ids */
        $ids = $this->dtoProperty($reporteQueryDTO);
        if($ids->ids === []) {
            // Si el array de ids está vacío, se asume que no se deben aplicar filtros (se incluyen todos los registros)
            return $query;
        }

        return $query->whereIn($this->relationColumn, $ids->ids);
    }
}
