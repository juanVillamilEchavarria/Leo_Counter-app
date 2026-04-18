<?php

namespace App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent;

use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\Abstracts\EloquentMovimientoTableQueryExecutor;
use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Infrastructure\Reporte\Builders\Eloquent\EloquentBalanceNetoBuilder;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelBalanceNetoCollection;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

/**
 * Balance Neto handler: calcula (ingresos - gastos) dependiendo la granularidad del periodo.
 *
 * Equivalente SQL:
 *   SELECT
 *     (COALESCE(SUM(CASE WHEN tipo_movimiento_id = ? THEN monto END), 0)
 *      - COALESCE(SUM(CASE WHEN tipo_movimiento_id = ? THEN monto END), 0)) AS balance,
 *     {granularity} as fecha
 *   FROM movimientos
 *   WHERE fecha BETWEEN ? AND ?
 *   GROUP BY {granularity}
 * 
 * ademas de resolver las relaciones necesarias dependiendo de los filtros aplicados (cuenta, categoria, etc).
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @package App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent
 */
final class EloquentBalanceNetoQueryExecutor extends EloquentMovimientoTableQueryExecutor implements ReporteQueryExecutorContract
{
    public function __construct(
        private readonly MovimientoQueryRelationResolver $relationResolver
    ) {}

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof MovimientoReportStatisticType && $type === MovimientoReportStatisticType::BALANCE_NETO;
    }

    public function handle(ReporteQuery $dto): LaravelBalanceNetoCollection
    {
        $date = $dto->granularityStrategy->groupBy();

        $query = $this->movimientos()
            ->selectRaw(
                "({$this->getConditionalSumQuery()} - {$this->getConditionalSumQuery()}) AS balance,
                 {$date} as fecha",
                [
                    TipoMovimientoEnum::INGRESO->value,
                    TipoMovimientoEnum::GASTO->value,
                ]
            );

        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query, "movimientos.fecha");
        $query = $this->relationResolver->resolve($query, $dto, MovimientoQueryRelationParam::TABLE);

        $query->groupByRaw($date);

        return EloquentBalanceNetoBuilder::buildCollection($query->get());
    }
}
