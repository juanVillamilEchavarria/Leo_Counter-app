<?php

namespace App\Infrastructure\QueryHandlers\Reporte\Movimiento\Eloquent;

use App\Infrastructure\QueryHandlers\Reporte\Abstracts\EloquentMovimientoTableQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Contracts\ReporteQueryHandlerContract;
use App\Infrastructure\Persistence\Builders\Reporte\EloquentBalanceNetoBuilder;
use App\Domains\Reporte\Enums\MovimientoReporteQueryType;
use App\Domains\Reporte\Enums\MovimientoQueryRelationParam;
use App\Infrastructure\QueryHandlers\Reporte\Movimiento\Resolvers\MovimientoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\Collections\BalanceNetoCollection;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\QueryBuilders\DomainQueryBuilder;
use App\Shared\Domain\Contracts\Reporte\ReporteQueryTypeContract;

/**
 * Balance Neto handler: computes (ingresos - gastos) per granularity period.
 *
 * SQL equivalent:
 *   SELECT
 *     (COALESCE(SUM(CASE WHEN tipo_movimiento_id = ? THEN monto END), 0)
 *      - COALESCE(SUM(CASE WHEN tipo_movimiento_id = ? THEN monto END), 0)) AS balance,
 *     {granularity} as fecha
 *   FROM movimientos
 *   WHERE fecha BETWEEN ? AND ?
 *   GROUP BY {granularity}
 */
final class EloquentBalanceNetoQueryHandler extends EloquentMovimientoTableQueryHandler implements ReporteQueryHandlerContract
{
    public function __construct(
        private readonly MovimientoQueryRelationResolver $relationResolver
    ) {}

    public function supports(ReporteQueryTypeContract $type): bool
    {
        return $type instanceof MovimientoReporteQueryType && $type === MovimientoReporteQueryType::BALANCE_NETO;
    }

    public function handle(ReporteQueryDTO $dto): BalanceNetoCollection
    {
        $date = $dto->granularityStrategy->groupBy();

        $query = new DomainQueryBuilder($this->movimientos())
            ->selectRaw(
                "({$this->getConditionalSumQuery()} - {$this->getConditionalSumQuery()}) AS balance,
                 {$date} as fecha",
                [
                    TipoMovimientoEnum::INGRESO->value,
                    TipoMovimientoEnum::GASTO->value,
                ]
            );

        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query = $this->relationResolver->resolve($query, $dto, MovimientoQueryRelationParam::TABLE);
        $query->groupByRaw($date);

        return EloquentBalanceNetoBuilder::buildCollection($query->get());
    }
}
