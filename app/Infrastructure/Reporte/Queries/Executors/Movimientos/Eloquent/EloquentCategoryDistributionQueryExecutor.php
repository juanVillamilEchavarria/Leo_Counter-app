<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent;

use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\Abstracts\EloquentMovimientoTableQueryExecutor;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos\MovimientoCategoriaQueryJoinRelationStrategy;
use App\Infrastructure\Reporte\Queries\Modifiers\Laravel\Movimientos\MovimientoTipoMovimientoQueryJoinRelationStrategy;
use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Infrastructure\Reporte\Builders\Eloquent\EloquentCategoryDistributionBuilder;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelCategoryDistributionCollection;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Models\Movimiento\Movimiento;
use Illuminate\Support\Facades\DB;

/**
 * Category Distribution handler: joins categorias and tipo_movimientos to
 * produce a per-category breakdown of totals and counts.
 *
 * SQL equivalent:
 *   SELECT
 *     categorias.nombre as categoria,
 *     tipo_movimientos.id as tipo_movimiento_id,
 *     COALESCE(SUM(movimientos.monto), 0) as total,
 *     COUNT(movimientos.id) as cantidad
 *   FROM movimientos
 *   INNER JOIN categorias ON movimientos.categoria_id = categorias.id
 *   INNER JOIN tipo_movimientos ON movimientos.tipo_movimiento_id = tipo_movimientos.id
 *   WHERE fecha BETWEEN ? AND ?
 *   GROUP BY categorias.id, categorias.nombre, tipo_movimientos.id, {granularity}
 *   ORDER BY total DESC
 */
final class EloquentCategoryDistributionQueryExecutor extends EloquentMovimientoTableQueryExecutor implements ReporteQueryExecutorContract
{

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof MovimientoReportStatisticType && $type === MovimientoReportStatisticType::CATEGORY_DISTRIBUTION;
    }

    public function execute(ReporteQuery $dto): LaravelCategoryDistributionCollection
    {
        $date = $dto->granularityStrategy->groupBy();

        $movimientosQuery = $this->movimientos()
        ->select('movimientos.categoria_id')
        ->selectRaw(
            "{$this->getSumQuery('movimientos.monto')} as total_categoria,
             {$this->getTableRecordsCountQuery('movimientos.id')} as cantidad_categoria,
                tipo_movimientos.id as tipo_movimiento_id
             "
        )
        ->join('tipo_movimientos', 'movimientos.tipo_movimiento_id', '=', 'tipo_movimientos.id')
        ->groupByRaw('movimientos.categoria_id, tipo_movimientos.id, ' . $date);
        $movimientosQuery = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $movimientosQuery, "movimientos.fecha");
        if(!empty($dto->categorias->ids)){
            $movimientosQuery->whereIn('movimientos.categoria_id', $dto->categorias->ids);
        }
        if(!empty($dto->cuentas->ids)){
            $movimientosQuery->whereIn('movimientos.cuenta_id', $dto->cuentas->ids);
        }

        $query = DB::table('categorias')
            ->joinSub(
                $movimientosQuery,
                'movimientos',
                'categorias.id',
                '=',
                'movimientos.categoria_id'
            )
            ->selectRaw(
                "categorias.nombre as categoria,
                 movimientos.tipo_movimiento_id as tipo_movimiento_id,
                 {$this->getSumQuery('movimientos.total_categoria')} as total,
                 {$this->getSumQuery('movimientos.cantidad_categoria')} as cantidad"
            )
             ->groupBy('categorias.id', 'categorias.nombre', 'movimientos.tipo_movimiento_id') 
            ->orderByDesc('total');  
        return EloquentCategoryDistributionBuilder::buildCollection($query->get());
    }
}
