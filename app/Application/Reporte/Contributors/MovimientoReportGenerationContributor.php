<?php

namespace App\Application\Reporte\Contributors;

use App\Application\Reporte\Contracts\ReportContributorContract;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\Enums\Domains\DomainReportQueryType;
use App\Application\Reporte\Orchestrators\MovimientoReportQueryOrchestrator;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

/**
 * Handler especializado en la generación de estadísticas del dominio Movimientos.
 * Implementa el contrato de contribuidor para integrarse en el reporte global
 * y también para responder consultas parciales de métricas específicas.
 *
 * Responsabilidades:
 * - Consultar datos estadisticos del dominio Movimientos
 * - Adjuntar datos comparativos del periodo anterior cuando aplique
 * - Exponer la contribución completa del dominio para el reporte global
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class MovimientoReportGenerationContributor implements ReportContributorContract
{
    /**
     * @param MovimientoReportQueryOrchestrator $queryOrchestrator Orchestrator de queries de movimientos.
     */
    public function __construct(
        private readonly MovimientoReportQueryOrchestrator $queryOrchestrator,
    ) {
    }

    /**
     * Genera estadísticas de movimientos para los tipos especificados.
     * Para tipos comparativos consulta el periodo anterior una única vez
     * y reutiliza el DTO resultante para evitar lógica duplicada.
     *
     * @param ReporteQueryDTO $dto Parámetros de la consulta.
     * @param array<int, ReportStatisticTypeContract> $types Tipos de métricas a calcular.
     * @return ReporteQueryResult
     */
    public function handle(ReporteQueryDTO $dto, array $types): ReporteQueryResult
    {
        $result = $this->queryOrchestrator->getMultiple($types, $dto);
        $previousDto = null;

        foreach ($types as $type) {
            if (!$type instanceof MovimientoReportStatisticType || !$type->requiresComparativeData()) {
                continue;
            }

            $previousDto ??= $dto->toPreviousPeriod();
            $previousCollection = $this->queryOrchestrator->get($type, $previousDto);
            $result = $result->addPrevious($type, $previousCollection);
        }

        return $result;
    }

    /**
     * Contribuye con el conjunto completo de estadísticas de movimientos.
     *
     * @param ReporteQueryDTO $dto Parámetros de la consulta.
     * @return ReporteQueryResult
     */
    public function contribute(ReporteQueryDTO $dto): ReporteQueryResult
    {
        return $this->handle($dto, MovimientoReportStatisticType::fullReport());
    }

    /**
     * Determina si este handler debe ejecutarse para los tipos solicitados.
     *
     * @param array<int, ReportStatisticTypeContract> $requestedTypes
     * @return bool
     */
    public function shouldContribute(array $requestedTypes): bool
    {
        // compara si los tipos solicitados son del tipo Movimiento
        return !empty(array_filter(
            $requestedTypes,
            static fn(ReportStatisticTypeContract $type): bool => $type instanceof MovimientoReportStatisticType
        ));
    }
}
