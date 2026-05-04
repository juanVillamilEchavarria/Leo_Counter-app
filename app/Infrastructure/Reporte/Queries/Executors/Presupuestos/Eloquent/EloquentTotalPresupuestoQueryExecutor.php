<?php

namespace App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Eloquent;

use App\Infrastructure\Reporte\Queries\Executors\Presupuestos\Eloquent\Abstracts\EloquentPresupuestoTableQueryExecutor;
use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Domains\Reporte\Enums\Statistic\PresupuestoReportStatisticType;
use App\Infrastructure\Reporte\Enums\Queries\Builders\PresupuestoQueryRelationParam;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\PresupuestoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

final class EloquentTotalPresupuestoQueryExecutor extends EloquentPresupuestoTableQueryExecutor implements ReporteQueryExecutorContract
{
    public function __construct(
        private readonly PresupuestoQueryRelationResolver $relationResolver
    ) {}

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof PresupuestoReportStatisticType && $type === PresupuestoReportStatisticType::TOTAL_PRESUPUESTO;
    }

    public function execute(ReporteQuery $dto): float
    {
        $query = $this->presupuestos();
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query, "presupuestos.periodo");
        return $query->sum('monto');
    }
}
