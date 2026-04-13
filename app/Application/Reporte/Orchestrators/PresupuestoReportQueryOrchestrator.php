<?php

namespace App\Application\Reporte\Orchestrators;

use App\Domains\Reporte\Contracts\Ports\DomainReportQueryOrchestrator;
use App\Domains\Reporte\Enums\Domains\DomainReportQueryType;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Application\Reporte\Contracts\Queries\ReporteQueryHandlerContract;

final class PresupuestoReportQueryOrchestrator implements DomainReportQueryOrchestrator
{

    public function __construct(
        /** @var iterable<ReporteQueryHandlerContract> */
        private readonly iterable $handlers
    ) {}

    public function supports(DomainReportQueryType $type): bool
    {
        return $type === DomainReportQueryType::PRESUPUESTOS;
    }

    public function get(ReportStatisticTypeContract $type, ReporteQueryDTO $dto): mixed
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($type)) {
                return $handler->handle($dto);
            }
        }
        throw new \InvalidArgumentException("No handler found for type: {$type->value}");
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