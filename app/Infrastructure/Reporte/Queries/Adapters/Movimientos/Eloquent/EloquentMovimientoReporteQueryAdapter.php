<?php

namespace App\Infrastructure\Reporte\Queries\Adapters\Movimientos\Eloquent;

use App\Domains\Reporte\Contracts\Ports\ReporteQueryPort;
use App\Domains\Reporte\Enums\Domains\DomainReportQueryType;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryHandlerResolver;

final class EloquentMovimientoReporteQueryAdapter implements ReporteQueryPort
{
    public function __construct(
        private readonly MovimientoQueryHandlerResolver $handlerResolver
    ) {}

    public function supports(DomainReportQueryType $type): bool
    {
        return $type === DomainReportQueryType::MOVIMIENTOS;
    }

    public function get(ReportStatisticTypeContract $type, ReporteQueryDTO $dto): mixed
    {
        return $this->handlerResolver->resolve($type)->handle($dto);
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
