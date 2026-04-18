<?php

namespace App\Application\Reporte\Orchestrators;

use App\Application\Reporte\Contracts\Orchestrators\DomainReportQueryOrchestrator;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;

final class PresupuestoReportQueryOrchestrator implements DomainReportQueryOrchestrator
{

    public function __construct(
        /** @var iterable<ReporteQueryExecutorContract> */
        private readonly iterable $handlers
    ) {}


    public function get(ReportStatisticTypeContract $type, ReporteQuery $dto): mixed
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($type)) {
                return $handler->handle($dto);
            }
        }
        throw new \InvalidArgumentException("No handler found for type: {$type->value}");
    }

    public function getMultiple(array $types, ReporteQuery $dto): ReporteQueryResult
    {
        return array_reduce(
            $types,
            fn(ReporteQueryResult $result, ReportStatisticTypeContract $type): ReporteQueryResult =>
                $result->add($type, $this->get($type, $dto)),
            new ReporteQueryResult()
        );
    }
}