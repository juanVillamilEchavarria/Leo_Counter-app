<?php

namespace App\Infrastructure\Reporte\Queries\Handlers\Presupuestos\Eloquent\Abstracts;

use App\Infrastructure\Reporte\Contracts\Queries\ReporteQueryHandlerContract;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Shared\QueryBuilders\ConditionalAggregateBuilder;
use App\Shared\Infrastructure\QueryBuilders\DomainQueryBuilder;
use DateTimeImmutable;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Clase abstracta padre para todos los query handlers de presupuestos basados en Eloquent
 * Encapsula metodos de construccion de consultas para evitar DRY
 * Solo handlers de la tabla de movimientos deben extender esta clase
 *
 * @author Juan Villamil
 * @package App\Infrastructure\QueryHandlers\Reporte\Abstracts
 * @since 1.0.0
 */
abstract class EloquentPresupuestoTableQueryHandler implements ReporteQueryHandlerContract
{
    abstract public function supports(ReportStatisticTypeContract $type): bool;
    abstract public function handle(ReporteQueryDTO $dto): mixed;

    /**
     * Consulta base de presupuestos
     */
    protected function presupuestos(): Builder
    {
        return DB::table('presupuestos');
    }

    /**
     * Aplica la filtracion por fecha (periodo) a la consulta
     */
    protected function baseQuery(
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        DomainQueryBuilder $query,
        string $column = 'presupuestos.periodo'
    ): DomainQueryBuilder {
        return $query->whereBetween($column, [$startDate, $endDate]);
    }

    /**
     * COALESCE(SUM(CASE WHEN presupuestos.tipo_movimiento_id = ? THEN monto END), 0)
         * Binding: el valor de TipoMovimientoEnum debe ser pasado en el array de bindings
     */
    protected function getConditionalSumQuery(): string
    {
        return ConditionalAggregateBuilder::make()
            ->aggregate('SUM')
            ->column('presupuestos.monto')
            ->conditionColumn('presupuestos.tipo_movimiento_id')
            ->useCoalesce(true)
            ->build();
    }

    /**
     * SUM(monto)
     */
    protected function getSumQuery(string $column = 'monto'): string
    {
        return "SUM({$column})";
    }

    /**
     * COUNT(*)
     */
    protected function getCountQuery(): string
    {
        return 'COUNT(*)';
    }

    /**
     * COUNT(DISTINCT movimientos.id)
     */
    protected function getMovimientosCountQuery(): string
    {
        return 'COUNT(DISTINCT movimientos.id)';
    }
}
