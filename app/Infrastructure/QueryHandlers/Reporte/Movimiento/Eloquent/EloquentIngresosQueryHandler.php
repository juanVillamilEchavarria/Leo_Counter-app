<?php

namespace App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent;

use App\Infrastructure\QueryHandlers\Reporte\Abstracts\EloquentMovimientoTableQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Contracts\ReporteQueryHandlerContract;
use App\Infrastructure\Persistence\Builders\Reporte\EloquentIngresosBuilder;
use App\Domains\Reporte\Enums\MovimientoReporteQueryType;
use App\Domains\Reporte\Enums\MovimientoQueryRelationParam;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Resolvers\MovimientoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\Collections\IngresosCollection;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\QueryBuilders\DomainQueryBuilder;
use App\Shared\Domain\Contracts\Reporte\ReporteQueryTypeContract;

final class EloquentIngresosQueryHandler extends EloquentMovimientoTableQueryHandler implements ReporteQueryHandlerContract
{
    public function __construct(
        private readonly MovimientoQueryRelationResolver $relationResolver
    ) {}

    public function supports(ReporteQueryTypeContract $type): bool
    {
        return $type instanceof MovimientoReporteQueryType && $type === MovimientoReporteQueryType::INGRESOS;
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
