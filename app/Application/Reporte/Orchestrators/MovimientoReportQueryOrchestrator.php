<?php

namespace App\Application\Reporte\Orchestrators;

use App\Domains\Reporte\Contracts\Ports\DomainReportQueryOrchestrator;
use App\Domains\Reporte\Enums\Domains\DomainReportQueryType;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

final class MovimientoReportQueryOrchestrator implements DomainReportQueryOrchestrator
{
    public function __construct(
        /** @var iterable<ReporteQueryHandlerContract> */
        private readonly iterable $handlers
    ) {}

    public function supports(DomainReportQueryType $type): bool
    {
        return $type === DomainReportQueryType::MOVIMIENTOS;
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
        $result = new ReporteQueryResult();

        /** @var ReportStatisticTypeContract $type */
        foreach ($types as $type) {
            $result = $result->add($type, $this->get($type, $dto));
        }

        return $result;
    }
}
