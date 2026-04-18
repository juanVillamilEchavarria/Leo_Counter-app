<?php

namespace App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent;

use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\Abstracts\EloquentMovimientoTableQueryExecutor;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos\MovimientoCategoriaQueryJoinRelationStrategy;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos\MovimientoTipoMovimientoQueryJoinRelationStrategy;
use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Infrastructure\Reporte\Builders\Eloquent\EloquentCategoryDistributionBuilder;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelCategoryDistributionCollection;
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
 *   GROUP BY categorias.id, categorias.nombre, tipo_movimientos.id, {granularity}
 *   ORDER BY total DESC
 */
final class EloquentCategoryDistributionQueryExecutor extends EloquentMovimientoTableQueryExecutor implements ReporteQueryExecutorContract
{
    public function __construct(
        private readonly MovimientoQueryRelationResolver $relationResolver
    ) {}

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof MovimientoReportStatisticType && $type === MovimientoReportStatisticType::CATEGORY_DISTRIBUTION;
    }

    public function handle(ReporteQuery $dto): LaravelCategoryDistributionCollection
    {
        $date = $dto->granularityStrategy->groupBy();
        $query = $this->movimientos()
            ->selectRaw(
                "categorias.nombre as categoria,
                 tipo_movimientos.id as tipo_movimiento_id,
                 {$this->getSumQuery('movimientos.monto')} as total,
                 {$this->getTableRecordsCountQuery('movimientos.id')} as cantidad"
            );

        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query, "movimientos.fecha");
        $query = $this->relationResolver->resolve($query, $dto, MovimientoQueryRelationParam::TABLE);
        $query = $this->relationResolver->resolve($query, $dto, MovimientoQueryRelationParam::TIPO_MOVIMIENTOS_JOIN);
        $query = $this->relationResolver->resolve($query, $dto, MovimientoQueryRelationParam::CATEGORIAS_JOIN);


        $query->groupByRaw("categorias.id, categorias.nombre, tipo_movimientos.id, {$date}")
              ->orderByDesc('total');
        return EloquentCategoryDistributionBuilder::buildCollection($query->get());
    }
}
