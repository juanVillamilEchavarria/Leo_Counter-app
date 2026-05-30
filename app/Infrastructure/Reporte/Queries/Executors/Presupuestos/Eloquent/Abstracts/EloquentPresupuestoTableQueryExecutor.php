<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Eloquent\Abstracts;

use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Queries\Executors\Abstracts\Eloquent\EloquentTableQueryExecutor;
use App\Shared\Infrastructure\Queries\Builders\ConditionalAggregateBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Clase abstracta padre para todos los query handlers de presupuestos basados en Eloquent
 * Encapsula metodos de construccion de consultas para evitar DRY
 * Solo handlers de la tabla de movimientos deben extender esta clase
 *
 * @author Juan Villamil
 * @package App\Infrastructure\QueryExecutors\Reporte\Abstracts
 * @since 1.0.0
 */
abstract class EloquentPresupuestoTableQueryExecutor extends EloquentTableQueryExecutor implements ReporteQueryExecutorContract
{
    abstract public function supports(ReportStatisticTypeContract $type): bool;
    abstract public function execute(ReporteQuery $dto): mixed;

    /**
     * Consulta base de presupuestos
     */
    protected function presupuestos(): Builder
    {
        return DB::table('presupuestos');
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



}
