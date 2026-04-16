<?php

namespace App\Application\Reporte\Contracts\Orchestrators;

use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;

/**
 * Contrato para los orchestrators encargadas de obtener las estadisticas de reportes por dominios
 * Cada dominio que afecte reportes debe tener un orchestrator que implementa este contrato
 * Las implementaciones de este contrato deben delegar el trabajo de obtener la estadistica (generar el query) al query handler correspondiente mediante el enum estadistico de su propio dominio (el enum que extiende a ReportStatisticTypeContract)
 * @example MovimientoReportQueryOrchestrator implements DomainReportQueryOrchestrator
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Reporte\Contracts\Orchestrators
 * @since 1.0.0
 * @version 1.0.0
 */
interface DomainReportQueryOrchestrator
{
    /**
     * Obtiene una estadistica
     * @param ReportStatisticTypeContract $type
     * @param ReporteQuery $dto
     * @return mixed - pues puede ser un int, float, string, DomainCollection, etc
     */
    public function get(ReportStatisticTypeContract $type, ReporteQuery $dto): mixed;
    /**
     * Obtiene multiples estadisticas
     * @param array<ReportStatisticTypeContract> $types
     * @param ReporteQuery $dto
     * @return ReporteQueryResult
     */
    public function getMultiple(array $types, ReporteQuery $dto): ReporteQueryResult;
}