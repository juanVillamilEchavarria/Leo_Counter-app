<?php

namespace App\Infrastructure\QueryHandlers\Reporte\Presupuesto\Eloquent;

use App\Infrastructure\QueryHandlers\Reporte\Abstracts\EloquentPresupuestoTableQueryHandler;
use App\Infrastructure\QueryHandlers\Reporte\Contracts\ReporteQueryHandlerContract;
use App\Domains\Reporte\Enums\PresupuestoReporteQueryType;
use App\Domains\Reporte\Enums\PresupuestoQueryRelationParam;
use App\Infrastructure\QueryHandlers\Reporte\Presupuesto\Resolvers\PresupuestoQueryRelationResolver;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Shared\Domain\Collections\DomainCollection;
use App\Shared\Domain\QueryBuilders\DomainQueryBuilder;
use App\Shared\Domain\Contracts\Reporte\ReporteQueryTypeContract;

final class EloquentTotalPresupuestoQueryHandler extends EloquentPresupuestoTableQueryHandler implements ReporteQueryHandlerContract
{
    public function __construct(
        private readonly PresupuestoQueryRelationResolver $relationResolver
    ) {}

    public function supports(ReporteQueryTypeContract $type): bool
    {
        return $type instanceof PresupuestoReporteQueryType && $type === PresupuestoReporteQueryType::TOTAL_PRESUPUESTO;
    }

    public function handle(ReporteQueryDTO $dto): DomainCollection
    {
        $query = new DomainQueryBuilder($this->presupuestos());
        $query = $this->baseQuery($dto->dateRange->startDate, $dto->dateRange->endDate, $query);
        $query = $this->relationResolver->resolve($query, $dto, PresupuestoQueryRelationParam::TABLE);

        // For now, return a simple collection. TODO: Create proper builder and collection
        return DomainCollection::make([$query->sum('monto')]);
    }
}