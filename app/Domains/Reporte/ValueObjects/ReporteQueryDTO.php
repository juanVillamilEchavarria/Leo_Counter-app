<?php

namespace App\Domains\Reporte\ValueObjects;

use App\Domains\Reporte\Contracts\Strategies\ReportGranularityStrategyContract;
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

    /**
     * Genera un nuevo ReporteQueryDTO desplazado al periodo anterior.
     * Mantiene todos los filtros originales de la consulta actual.
     *
     * @return self
     */
    public function toPreviousPeriod(): self
    {
        return new self(
            granularityStrategy: $this->granularityStrategy,
            dateRange: $this->dateRange->toPreviousPeriod(),
            only_categorias_fijas: $this->only_categorias_fijas,
            categorias: $this->categorias,
            cuentas: $this->cuentas
        );
    }
}
