<?php

namespace App\Domains\Reporte\Contracts\Ports;

use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\Enums\Domains\DomainReportQueryType;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;

/**
 * Contrato para los orchestrators encargadas de obtener las estadisticas de reportes por dominios
 * Cada dominio que afecte reportes debe tener un orchestrator que implementa este contrato
 * Las implementaciones de este contrato deben delegar el trabajo de obtener la estadistica (generar el query) al query handler correspondiente mediante el enum estadistico de su propio dominio (el enum que extiende a ReportStatisticTypeContract)
 * @example MovimientoReportQueryOrchestrator implements DomainReportQueryOrchestrator
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Reporte\Contracts\Ports
 * @since 1.0.0
 * @version 1.0.0
 */
interface DomainReportQueryOrchestrator
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