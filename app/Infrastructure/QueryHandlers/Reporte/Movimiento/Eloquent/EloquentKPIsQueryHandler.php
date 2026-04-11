<?php

namespace App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent;

use App\Infrastructure\QueryHandlers\Reporte\Abstracts\EloquentMovimientoTableQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Contracts\ReporteQueryHandlerContract;
use App\Infrastructure\Persistence\Builders\Reporte\EloquentKPIBuilder;
use App\Domains\Reporte\Enums\MovimientoReporteQueryType;
use App\Domains\Reporte\Enums\MovimientoQueryRelationParam;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Resolvers\MovimientoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\Collections\KPICollection;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\QueryBuilders\DomainQueryBuilder;
use App\Shared\Domain\Contracts\Reporte\ReporteQueryTypeContract;

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

    public function supports(ReporteQueryTypeContract $type): bool
    {
        return $type instanceof MovimientoReporteQueryType && $type === MovimientoReporteQueryType::KPIS;
    }

    public function handle(ReporteQueryDTO $dto): KPICollection
    {
        $date = $dto->granularityStrategy->groupBy();

        $query = new DomainQueryBuilder($this->movimientos())
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
