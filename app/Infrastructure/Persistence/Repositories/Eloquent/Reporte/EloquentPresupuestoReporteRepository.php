<?php

namespace App\Infrastructure\Persistence\Repositories\Eloquent\Reporte;

use App\Domains\Reporte\Contracts\Repositories\ReporteModelRepositoryContract;
use App\Domains\Reporte\Enums\ReporteRepositoryType;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Shared\Domain\Collections\DomainCollection;
use App\Shared\Domain\Contracts\Reporte\ReporteQueryTypeContract;
use App\Infrastructure\QueryHandlers\Reporte\Presupuesto\Resolvers\PresupuestoQueryHandlerResolver;

final class EloquentPresupuestoReporteRepository implements ReporteModelRepositoryContract
{
    public function __construct(
        private readonly PresupuestoQueryHandlerResolver $handlerResolver
    ) {}

    public function supports(ReporteRepositoryType $type): bool
    {
        return $type === ReporteRepositoryType::PRESUPUESTOS;
    }

    public function get(ReporteQueryTypeContract $type, ReporteQueryDTO $dto): mixed
    {
        return $this->handlerResolver->resolve($type)->handle($dto);
    }

    public function getMultiple(array $types, ReporteQueryDTO $dto): ReporteQueryResult
    {
        return array_reduce(
            $types,
            fn(ReporteQueryResult $result, ReporteQueryTypeContract $type): ReporteQueryResult =>
                $result->add($type, $this->get($type, $dto)),
            new ReporteQueryResult()
        );
    }
}