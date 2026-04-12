<?php

namespace App\Infrastructure\Reporte\Contracts\Queries;

use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;

interface ReporteQueryHandlerContract
{
    public function supports(ReportStatisticTypeContract $type): bool;

    public function handle(ReporteQueryDTO $dto): mixed;
}
