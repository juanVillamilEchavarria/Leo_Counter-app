<?php

namespace App\Infrastructure\Reporte\Queries\Handlers\Presupuestos\Eloquent;

use App\Infrastructure\Reporte\Queries\Handlers\Presupuestos\Eloquent\Abstracts\EloquentPresupuestoTableQueryHandler;
use App\Infrastructure\Reporte\Contracts\Queries\ReporteQueryHandlerContract;
use App\Domains\Reporte\Enums\Statistic\PresupuestoReportStatisticType;
use App\Infrastructure\Reporte\Enums\Queries\Builders\PresupuestoQueryRelationParam;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\PresupuestoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

final class EloquentTotalPresupuestoQueryHandler extends EloquentPresupuestoTableQueryHandler implements ReporteQueryHandlerContract
{
    public function __construct(
        private readonly PresupuestoQueryRelationResolver $relationResolver
    ) {}

    public function supports(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof PresupuestoReportStatisticType && $type === PresupuestoReportStatisticType::TOTAL_PRESUPUESTO;
    }

    public function handle(ReporteQueryDTO $dto): float
    {
        $query = $this->presupuestos();
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query = $this->relationResolver->resolve($query, $dto, PresupuestoQueryRelationParam::TABLE);

        return $query->sum('monto');
    }
}
