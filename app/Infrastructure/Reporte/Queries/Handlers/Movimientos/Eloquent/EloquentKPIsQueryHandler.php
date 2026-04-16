<?php

namespace App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent;

use App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent\Abstracts\EloquentMovimientoTableQueryHandler;
use App\Application\Reporte\Contracts\Queries\ReporteQueryHandlerContract;
use App\Infrastructure\Reporte\Builders\Eloquent\EloquentKPIBuilder;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelKPICollection;
use App\Domains\Reporte\Contracts\Collections\Movimientos\KPICollectionContract;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

/**
 * KPIs handler: computes total_ingresos, total_gastos, and total_movimientos
 * grouped by the granularity period.
 *
 * SQL equivalent:
 *   SELECT
 *     COALESCE(SUM(CASE WHEN tipo_movimiento_id = ? THEN monto END), 0) AS total_ingresos,
 *     COALESCE(SUM(CASE WHEN tipo_movimiento_id = ? THEN monto END), 0) AS total_gastos,
 *     COUNT(movimientos.id) AS total_movimientos,
 *     {granularity} as fecha
 *   FROM movimientos
 *   WHERE fecha BETWEEN ? AND ?
 *   GROUP BY {granularity}
 */
final class EloquentKPIsQueryHandler extends EloquentMovimientoTableQueryHandler implements ReporteQueryHandlerContract
{
    public function __construct(
        private readonly MovimientoQueryRelationResolver $relationResolver
    ) {}

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof MovimientoReportStatisticType && $type === MovimientoReportStatisticType::KPIS;
    }

    public function handle(ReporteQuery $dto): LaravelKPICollection
    {
        $date = $dto->granularityStrategy->groupBy();

        $query = $this->movimientos()
            ->selectRaw(
                "{$this->getConditionalSumQuery()} AS total_ingresos,
                 {$this->getConditionalSumQuery()} AS total_gastos,
                 {$this->getMovimientosCountQuery()} AS total_movimientos,
                 {$date} as fecha",
                [
                    TipoMovimientoEnum::INGRESO->value,
                    TipoMovimientoEnum::GASTO->value,
                ]
            );

        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query = $this->relationResolver->resolve($query, $dto, MovimientoQueryRelationParam::TABLE);
        $query->groupByRaw($date);

        return EloquentKPIBuilder::buildCollection($query->get());
    }
}
