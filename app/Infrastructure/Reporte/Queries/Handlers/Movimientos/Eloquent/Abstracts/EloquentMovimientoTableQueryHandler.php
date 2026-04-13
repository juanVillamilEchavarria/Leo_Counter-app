<?php

namespace App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent\Abstracts;

use App\Infrastructure\Reporte\Contracts\Queries\ReporteQueryHandlerContract;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Shared\Domain\Collections\DomainCollection;
use App\Shared\QueryBuilders\ConditionalAggregateBuilder;
use DateTimeImmutable;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Clase abstracta padre para manejar los query handlers de movimientos basados en Eloquent.
 * Encapsula metodos de construccion de consultas para evitar DRY
 * Solo handlers de la tabla de movimientos deben extender esta clase
 *
 * @author Juan Villamil
 * @package App\Infrastructure\QueryHandlers\Reporte\Abstracts
 * @since 1.0.0
 */
abstract class EloquentMovimientoTableQueryHandler implements ReporteQueryHandlerContract
{
    abstract public function supports(ReportStatisticTypeContract $type): bool;
    abstract public function handle(ReporteQueryDTO $dto): mixed;

    /**
     * Consulta base de movimientos
     */
    protected function movimientos(): Builder
    {
        return DB::table('movimientos');
    }

    /**
     * Aplica la filtracion por fecha (periodo) a la consulta
     */
    protected function baseQuery(
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        Builder $query,
        string $column = 'movimientos.fecha'
    ): Builder {
        return $query->whereBetween($column, [$startDate, $endDate]);
    }

    /**
     * COALESCE(SUM(CASE WHEN movimientos.tipo_movimiento_id = ? THEN monto END), 0)
     * Binding: el valor de TipoMovimientoEnum debe ser pasado en el array de bindings
     */
    protected function getConditionalSumQuery(): string
    {
        return ConditionalAggregateBuilder::make()
            ->aggregate('SUM')
            ->column('movimientos.monto')
            ->conditionColumn('movimientos.tipo_movimiento_id')
            ->useCoalesce(true)
            ->build();
    }

    /**
     * COALESCE(SUM(column), 0)
     * Sin condicionales- suma todos los montos
     */
    protected function getSumQuery(string $column = 'monto'): string
    {
        return ConditionalAggregateBuilder::make()
            ->aggregate('SUM')
            ->column($column)
            ->useCoalesce(true)
            ->build();
    }

    /**
     * COUNT(movimientos.id)
     * Sin condicionales - cuenta todos los movimientos
     */
    protected function getMovimientosCountQuery(): string
    {
        return ConditionalAggregateBuilder::make()
            ->aggregate('COUNT')
            ->column('movimientos.id')
            ->useCoalesce(false)
            ->build();
    }

    /**
     * COALESCE(COUNT(CASE WHEN movimientos.tipo_movimiento_id = ? THEN 1 END), 0)
     * Binding: el valor de TipoMovimientoEnum debe ser pasado en el array de bindings
     */
    protected function getConditionalCountQuery(): string
    {
        return ConditionalAggregateBuilder::make()
            ->aggregate('COUNT')
            ->column('movimientos.id')
            ->conditionColumn('movimientos.tipo_movimiento_id')
            ->useCoalesce(true)
            ->build();
    }

}
