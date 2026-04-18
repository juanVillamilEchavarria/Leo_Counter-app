<?php

namespace App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent;

use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\Abstracts\EloquentMovimientoTableQueryExecutor;
use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Infrastructure\Reporte\Builders\Eloquent\EloquentIngresosBuilder;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelMetricPointCollection;
use App\Domains\Reporte\Contracts\Collections\Movimientos\MetricPointCollectionContract;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

final class EloquentIngresosQueryExecutor extends EloquentMovimientoTableQueryExecutor implements ReporteQueryExecutorContract
{
    public function __construct(
        private readonly MovimientoQueryRelationResolver $relationResolver
    ) {}

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof MovimientoReportStatisticType && $type === MovimientoReportStatisticType::INGRESOS;
    }

    public function handle(ReporteQuery $dto): LaravelMetricPointCollection
    {
        $query = $this->movimientos()
            ->selectRaw("{$dto->granularityStrategy->groupBy()} as fecha, {$this->getSumQuery('monto')} as monto");

        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query, "movimientos.fecha");
        $query = $this->relationResolver->resolve($query, $dto, MovimientoQueryRelationParam::TABLE);
        $query = $query->where('tipo_movimiento_id', TipoMovimientoEnum::INGRESO->value);
        $query->groupByRaw($dto->granularityStrategy->groupBy())->orderBy('fecha');

        return EloquentIngresosBuilder::buildCollection($query->get());
    }
}
