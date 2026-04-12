<?php

namespace App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent;

use App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent\Abstracts\EloquentMovimientoTableQueryHandler;
use App\Infrastructure\Reporte\Contracts\Queries\ReporteQueryHandlerContract;
use App\Infrastructure\Reporte\Builders\Eloquent\EloquentGastosBuilder;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\Collections\GastosCollection;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Infrastructure\QueryBuilders\DomainQueryBuilder;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

final class EloquentGastosQueryHandler extends EloquentMovimientoTableQueryHandler implements ReporteQueryHandlerContract
{
    public function __construct(
        private readonly MovimientoQueryRelationResolver $relationResolver
    ) {}

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof MovimientoReportStatisticType && $type === MovimientoReportStatisticType::GASTOS;
    }

    public function handle(ReporteQueryDTO $dto): GastosCollection
    {
        $query = new DomainQueryBuilder($this->movimientos())
            ->selectRaw("{$dto->granularityStrategy->groupBy()} as fecha, {$this->getSumQuery('monto')} as monto");

        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query = $this->relationResolver->resolve($query, $dto, MovimientoQueryRelationParam::TABLE);
        $query = $query->where('tipo_movimiento_id', TipoMovimientoEnum::GASTO->value);
        $query->groupByRaw($dto->granularityStrategy->groupBy())->orderBy('fecha');

        return EloquentGastosBuilder::buildCollection($query->get());
    }
}
