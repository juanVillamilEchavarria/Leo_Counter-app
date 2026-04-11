<?php

namespace App\Domains\Reporte\ValueObjects;

use App\Domains\Reporte\Contracts\Strategies\ReportGranularityStrategyContract;
use App\Domains\Reporte\ValueObjects\DateRange;
use App\Shared\DTOs\Querys\IdsDTO;

final class ReporteQueryDTO
{
    public function __construct(
        public ReportGranularityStrategyContract $granularityStrategy,
        public DateRange $dateRange,
        public bool $only_categorias_fijas = false,
        public ?IdsDTO $categorias = null,
        public ?IdsDTO $cuentas = null
    ) {
    }
}
