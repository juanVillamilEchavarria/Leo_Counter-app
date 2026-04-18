<?php

namespace App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent;

use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\Abstracts\EloquentMovimientoTableQueryExecutor;
use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Infrastructure\Reporte\Builders\Eloquent\EloquentFinancialPeriodBuilder;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelIncomeExpenseCollection;
use App\Domains\Reporte\Collections\IncomeExpensePeriodCollection;
use App\Domains\Reporte\Contracts\Collections\Movimientos\IncomeExpenseCollectionContract;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

/**
 * Ingresos vs Gastos handler: returns per-period sums and counts for both
 * ingresos and gastos, enabling comparison charts.
 *
 * SQL equivalent:
 *   SELECT
 *     COALESCE(SUM(CASE WHEN tipo_movimiento_id = ? THEN monto END), 0) AS ingresos,
 *     COALESCE(SUM(CASE WHEN tipo_movimiento_id = ? THEN monto END), 0) AS gastos,
 *     COALESCE(COUNT(CASE WHEN tipo_movimiento_id = ? THEN 1 END), 0) AS count_ingresos,
 *     COALESCE(COUNT(CASE WHEN tipo_movimiento_id = ? THEN 1 END), 0) AS count_gastos,
 *     {granularity} as fecha
 *   FROM movimientos
 *   WHERE fecha BETWEEN ? AND ?
 *   GROUP BY {granularity}
 *   ORDER BY fecha
 */
final class EloquentIngresosVsGastosQueryExecutor extends EloquentMovimientoTableQueryExecutor implements ReporteQueryExecutorContract
{
    public function __construct(
        private readonly MovimientoQueryRelationResolver $relationResolver
    ) {}

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof MovimientoReportStatisticType && $type === MovimientoReportStatisticType::INGRESOS_VS_GASTOS;
    }

    public function handle(ReporteQuery $dto): LaravelIncomeExpenseCollection
    {
        $date = $dto->granularityStrategy->groupBy();

        $query = $this->movimientos()
            ->selectRaw(
                "{$this->getConditionalSumQuery()} AS ingresos,
                 {$this->getConditionalSumQuery()} AS gastos,
                 {$this->getConditionalCountQuery()} AS count_ingresos,
                 {$this->getConditionalCountQuery()} AS count_gastos,
                 {$date} as fecha",
                [
                    TipoMovimientoEnum::INGRESO->value,
                    TipoMovimientoEnum::GASTO->value,
                    TipoMovimientoEnum::INGRESO->value,
                    TipoMovimientoEnum::GASTO->value,
                ]
            );

        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query, "movimientos.fecha");
        $query = $this->relationResolver->resolve($query, $dto, MovimientoQueryRelationParam::TABLE);
        $query->groupByRaw($date)->orderBy('fecha');

        return EloquentFinancialPeriodBuilder::buildCollection($query->get());
    }
}
