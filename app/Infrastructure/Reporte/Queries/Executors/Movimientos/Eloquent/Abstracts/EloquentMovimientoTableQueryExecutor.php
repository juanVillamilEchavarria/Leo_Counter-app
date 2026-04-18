<?php

namespace App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\Abstracts;

use App\Infrastructure\Reporte\Queries\Executors\Abstracts\Eloquent\EloquentTableQueryExecutor;
use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
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
 * @package App\Infrastructure\QueryExecutors\Reporte\Abstracts
 * @since 1.0.0
 */
abstract class EloquentMovimientoTableQueryExecutor extends EloquentTableQueryExecutor implements ReporteQueryExecutorContract
{
    abstract public function supports(ReportStatisticTypeContract $type): bool;
    abstract public function handle(ReporteQuery $dto): mixed;

    /**
     * Consulta base de movimientos
     */
    protected function movimientos(): Builder
    {
        return DB::table('movimientos');
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
