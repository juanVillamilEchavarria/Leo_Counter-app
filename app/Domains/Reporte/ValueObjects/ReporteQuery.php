<?php

namespace App\Domains\Reporte\ValueObjects;

use App\Domains\Reporte\Contracts\Strategies\ReportGranularityStrategyContract;
use App\Shared\Domain\ValueObjects\Ids;

/**
 * Value Object que representa los filtros y parametros que se necesita para ejecutar una consulta de reportes.
 * Este objeto es inmutable, por lo que cada vez que se necesite modificar alguno de sus parametros, se debe crear una nueva instancia del mismo.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Reporte\ValueObjects
 * @since 1.0.0
 * @version 1.0.0
 */
final class ReporteQuery
{
    public function __construct(
        public ReportGranularityStrategyContract $granularityStrategy,
        public DateRange $dateRange,
        public bool $only_categorias_fijas = false,
        public ?Ids $categorias = null,
        public ?Ids $cuentas = null
    ) {
    }

    /**
     * Genera un nuevo ReporteQuery desplazado al periodo anterior.
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
