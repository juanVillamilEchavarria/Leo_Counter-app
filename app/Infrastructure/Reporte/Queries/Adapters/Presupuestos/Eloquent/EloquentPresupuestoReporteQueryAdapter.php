<?php

namespace App\Infrastructure\Reporte\Queries\Adapters\Presupuestos\Eloquent;

use App\Domains\Reporte\Contracts\Ports\ReporteQueryPort;
use App\Domains\Reporte\Enums\Domains\DomainReportQueryType;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\PresupuestoQueryHandlerResolver;

final class EloquentPresupuestoReporteQueryAdapter implements ReporteQueryPort
{

    public function __construct(
        private readonly PresupuestoQueryHandlerResolver $handlerResolver
    ) {}

    public function supports(DomainReportQueryType $type): bool
    {
        return $type === DomainReportQueryType::PRESUPUESTOS;
    }

    public function get(ReportStatisticTypeContract $type, ReporteQueryDTO $dto): mixed
    {
        return $this->handlerResolver->resolve($type)->handle($dto);
    }

    public function getMultiple(array $types, ReporteQueryDTO $dto): ReporteQueryResult
    {
        return array_reduce(
            $types,
            fn(ReporteQueryResult $result, ReportStatisticTypeContract $type): ReporteQueryResult =>
                $result->add($type, $this->get($type, $dto)),
            new ReporteQueryResult()
        );
    }
}