<?php

namespace App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent;

use App\Infrastructure\QueryHandlers\Reporte\Abstracts\EloquentMovimientoTableQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Contracts\ReporteQueryHandlerContract;
use App\Infrastructure\Persistence\Builders\Reporte\EloquentCategoryDistributionBuilder;
use App\Domains\Reporte\Enums\MovimientoReporteQueryType;
use App\Domains\Reporte\Enums\MovimientoQueryRelationParam;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Resolvers\MovimientoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\Collections\DistributionCategoryCollection;
use App\Shared\Domain\QueryBuilders\DomainQueryBuilder;
use App\Shared\Domain\Contracts\Reporte\ReporteQueryTypeContract;

/**
 * Category Distribution handler: joins categorias and tipo_movimientos to
 * produce a per-category breakdown of totals and counts.
 *
 * SQL equivalent:
 *   SELECT
 *     categorias.nombre as categoria,
 *     tipo_movimientos.id as tipo_movimiento_id,
 *     COALESCE(SUM(movimientos.monto), 0) as total,
 *     COUNT(movimientos.id) as cantidad
 *   FROM movimientos
 *   INNER JOIN categorias ON movimientos.categoria_id = categorias.id
 *   INNER JOIN tipo_movimientos ON movimientos.tipo_movimiento_id = tipo_movimientos.id
 *   WHERE fecha BETWEEN ? AND ?
 *   GROUP BY categorias.id, categorias.nombre, tipo_movimientos.id
 *   ORDER BY total DESC
 */
final class EloquentCategoryDistributionQueryHandler extends EloquentMovimientoTableQueryHandler implements ReporteQueryHandlerContract
{
    public function __construct(
        private readonly MovimientoQueryRelationResolver $relationResolver
    ) {}

    public function supports(ReporteQueryTypeContract $type): bool
    {
        return $type instanceof MovimientoReporteQueryType && $type === MovimientoReporteQueryType::CATEGORY_DISTRIBUTION;
    }

    public function handle(ReporteQueryDTO $dto): DistributionCategoryCollection
    {
        $query = new DomainQueryBuilder($this->movimientos())
            ->selectRaw(
                "categorias.nombre as categoria,
                 tipo_movimientos.id as tipo_movimiento_id,
                 {$this->getSumQuery('movimientos.monto')} as total,
                 {$this->getMovimientosCountQuery()} as cantidad"
            );

        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query = $this->relationResolver->resolve($query, $dto, MovimientoQueryRelationParam::TABLE);
        $query = $this->relationResolver->resolve($query, $dto, MovimientoQueryRelationParam::TIPO_MOVIMIENTOS_JOIN);
        $query = $this->relationResolver->resolve($query, $dto, MovimientoQueryRelationParam::CATEGORIAS_JOIN);

        $query->groupBy('categorias.id', 'categorias.nombre', 'tipo_movimientos.id')
              ->orderByDesc('total');

        return EloquentCategoryDistributionBuilder::buildCollection($query->get());
    }
}
