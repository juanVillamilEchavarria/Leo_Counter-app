<?php

namespace App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Eloquent;

use App\Infrastructure\Reporte\Enums\Queries\Builders\MovimientoQueryRelationParam;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryRelationResolver;
use App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Eloquent\Abstracts\EloquentPresupuestoTableQueryExecutor;
use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Domains\Reporte\Enums\Statistic\PresupuestoReportStatisticType;
use App\Infrastructure\Reporte\Enums\Queries\Builders\PresupuestoQueryRelationParam;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\PresupuestoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Infrastructure\Reporte\Builders\Eloquent\EloquentUsedBudgetBuilder;
use App\Domains\Reporte\ValueObjects\Budget\UsedBudgetVO;

final class EloquentUsedBudgetQueryExecutor extends EloquentPresupuestoTableQueryExecutor implements ReporteQueryExecutorContract
{

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof PresupuestoReportStatisticType 
            && $type === PresupuestoReportStatisticType::USED_BUDGET;
    }

    public function execute(ReporteQuery $dto): UsedBudgetVO
    {
        // Construir query base con JOIN
        $query = $this->presupuestos()
            ->leftJoin('movimientos', function ($join) use ($dto) {
                $join->on('presupuestos.categoria_id', '=', 'movimientos.categoria_id')
                     ->where('movimientos.tipo_movimiento_id', '=', TipoMovimientoEnum::GASTO->value)
                     ->whereBetween('movimientos.fecha', [$dto->dateRange->startDate, $dto->dateRange->endDate]);
            })
            ->selectRaw('
                COALESCE(SUM(presupuestos.monto), 0) as total_presupuesto,
                COALESCE(SUM(movimientos.monto), 0) as total_gastos,
                (COALESCE(SUM(presupuestos.monto), 0) - COALESCE(SUM(movimientos.monto), 0)) as disponible
            ');

        // Aplicar baseQuery con rango de fechas para presupuestos
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query, "presupuestos.periodo");
        // Ejecutar y construir VO
        $result = $query->first();

        return EloquentUsedBudgetBuilder::build($result);
    }
}
