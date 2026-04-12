<?php

namespace App\Domains\Reporte\Contracts\Ports;

use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\Enums\Domains\DomainReportQueryType;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;

/**
 * Contrato para las implementaciones encargadas de obtener las estadisticas de reportes
 * Cada dominio que afecte reportes debe tener un adaptador que implementa este contrato
 * @example EloquentReporteMovimientoQueryAdapter implements ReporteQueryPort
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Reporte\Contracts\Ports
 * @since 1.0.0
 * @version 1.0.0
 */
interface ReporteQueryPort
{
    /**
     * Define si el tipo de reporte es soportado por el query handler manager
     * @param DomainReportQueryType $type
     * @return bool
     */
    public function supports(DomainReportQueryType $type): bool;
    /**
     * Obtiene una estadistica
     * @param ReportStatisticTypeContract $type
     * @param ReporteQueryDTO $dto
     * @return mixed - pues puede ser un int, float, string, DomainCollection, etc
     */
    public function get(ReportStatisticTypeContract $type, ReporteQueryDTO $dto): mixed;
    /**
     * Obtiene multiples estadisticas
     * @param array<ReportStatisticTypeContract> $types
     * @param ReporteQueryDTO $dto
     * @return ReporteQueryResult
     */
    public function getMultiple(array $types, ReporteQueryDTO $dto): ReporteQueryResult;
}