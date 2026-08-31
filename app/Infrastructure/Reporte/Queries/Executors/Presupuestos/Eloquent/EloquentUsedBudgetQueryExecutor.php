<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Eloquent;

use App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Eloquent\Abstracts\EloquentPresupuestoTableQueryExecutor;
use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Domains\Reporte\Enums\Statistic\PresupuestoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Infrastructure\Reporte\Builders\Eloquent\EloquentUsedBudgetBuilder;
use App\Domains\Reporte\ValueObjects\Budget\UsedBudgetVO;
use App\Models\Movimiento\Movimiento;
use App\Models\Categoria\Categoria;
use DB;

final class EloquentUsedBudgetQueryExecutor extends EloquentPresupuestoTableQueryExecutor implements ReporteQueryExecutorContract
{

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof PresupuestoReportStatisticType
            && $type === PresupuestoReportStatisticType::USED_BUDGET;
    }

    public function execute(ReporteQuery $dto): UsedBudgetVO
    {
        $startDate = $dto->dateRange->startDate;
        $endDate   = $dto->dateRange->endDate;

        //  Presupuesto agrupado por categoría
        $presupuestosPorCategoria = $this->presupuestos()
            ->select('presupuestos.categoria_id')
            ->selectRaw('SUM(presupuestos.monto) as total_categoria')
            ->whereNull('presupuestos.deleted_at')
            ->whereBetween('presupuestos.periodo', [$startDate, $endDate])
            ->groupBy('presupuestos.categoria_id');

        //  Gastos agrupados por categoría
        $gastosPorCategoria = Movimiento::query()
            ->select('movimientos.categoria_id')
            ->selectRaw('SUM(movimientos.monto) as total_categoria')
            ->whereNull('movimientos.deleted_at')
            ->where('movimientos.tipo_movimiento_id', TipoMovimientoEnum::GASTO->value)
            ->whereBetween('movimientos.fecha', [$startDate, $endDate])
            ->groupBy('movimientos.categoria_id');

        // Estadisticas en general uniendo los resultados de las dos subqueries
        $query = DB::table('categorias')
            ->joinSub(
                $presupuestosPorCategoria,
                'presupuesto_agg',
                'categorias.id',
                '=',
                'presupuesto_agg.categoria_id'
            )
            ->leftJoinSub(
                $gastosPorCategoria,
                'gasto_agg',
                'categorias.id',
                '=',
                'gasto_agg.categoria_id'
            )
            ->selectRaw('
                COALESCE(SUM(presupuesto_agg.total_categoria), 0) as total_presupuesto,
                COALESCE(SUM(gasto_agg.total_categoria), 0) as total_gastos,
                COALESCE(SUM(presupuesto_agg.total_categoria), 0) - COALESCE(SUM(gasto_agg.total_categoria), 0) as disponible
            ');

        $result = $query->first();
        return EloquentUsedBudgetBuilder::build($result);
    }
}
