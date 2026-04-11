<?php

namespace App\Infrastructure\QueryHandlers\Reporte\Contracts;

use App\Shared\Domain\Contracts\Reporte\ReporteQueryTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Shared\Domain\Collections\DomainCollection;

interface ReporteQueryHandlerContract
{
    public function supports(ReporteQueryTypeContract $type): bool;

    public function handle(ReporteQueryDTO $dto): mixed;
}
