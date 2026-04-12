<?php

namespace App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent;

use App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent\Abstracts\EloquentMovimientoTableQueryHandler;
use App\Infrastructure\Reporte\Contracts\Queries\ReporteQueryHandlerContract;
use App\Infrastructure\Reporte\Builders\Eloquent\EloquentCategoryDistributionBuilder;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\Collections\DistributionCategoryCollection;
use App\Shared\Infrastructure\QueryBuilders\DomainQueryBuilder;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

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

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof MovimientoReportStatisticType && $type === MovimientoReportStatisticType::CATEGORY_DISTRIBUTION;
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
