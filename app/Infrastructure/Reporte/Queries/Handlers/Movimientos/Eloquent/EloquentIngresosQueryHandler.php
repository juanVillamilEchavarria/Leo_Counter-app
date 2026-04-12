<?php

namespace App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent;

use App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent\Abstracts\EloquentMovimientoTableQueryHandler;
use App\Infrastructure\Reporte\Contracts\Queries\ReporteQueryHandlerContract;
use App\Infrastructure\Reporte\Builders\Eloquent\EloquentIngresosBuilder;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\Collections\IngresosCollection;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Infrastructure\QueryBuilders\DomainQueryBuilder;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

final class EloquentIngresosQueryHandler extends EloquentMovimientoTableQueryHandler implements ReporteQueryHandlerContract
{
    public function __construct(
        private readonly MovimientoQueryRelationResolver $relationResolver
    ) {}

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof MovimientoReportStatisticType && $type === MovimientoReportStatisticType::INGRESOS;
    }

    public function handle(ReporteQueryDTO $dto): IngresosCollection
    {
        $query = new DomainQueryBuilder($this->movimientos())
            ->selectRaw("{$dto->granularityStrategy->groupBy()} as fecha, {$this->getSumQuery('monto')} as monto");

        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query = $this->relationResolver->resolve($query, $dto, MovimientoQueryRelationParam::TABLE);
        $query = $query->where('tipo_movimiento_id', TipoMovimientoEnum::INGRESO->value);
        $query->groupByRaw($dto->granularityStrategy->groupBy())->orderBy('fecha');

        return EloquentIngresosBuilder::buildCollection($query->get());
    }
}
