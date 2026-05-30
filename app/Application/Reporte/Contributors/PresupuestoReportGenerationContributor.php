<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Reporte\Contributors;

use App\Application\Reporte\Contracts\ReportContributorContract;
use App\Domains\Reporte\Enums\Statistic\PresupuestoReportStatisticType;
use App\Application\Reporte\Orchestrators\PresupuestoReportQueryOrchestrator;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;

/**
 * Handler especializado en la generación de estadísticas del dominio Presupuestos.
 * Implementa el contrato de contribuidor para integrarse en el reporte global
 * y también para responder consultas parciales de métricas específicas.
 * * Responsabilidades:
 * - Consultar datos estadisticos del dominio Presupuestos
 * - Adjuntar datos comparativos del periodo anterior cuando aplique
 * - Exponer la contribución completa del dominio para el reporte global
 *
 * @author Juan Villamil
 * @since 1.0.0
 */
final class PresupuestoReportGenerationContributor implements ReportContributorContract
{
    /**
     * @param PresupuestoReportQueryOrchestrator $queryOrchestrator Orchestrator de queries de presupuestos.
     */
    public function __construct(
        private readonly PresupuestoReportQueryOrchestrator $queryOrchestrator,
    ) {
    }

    /**
     * Genera estadísticas de presupuestos para los tipos especificados.
     *
     * @param ReporteQuery $dto Parámetros de la consulta.
     * @param array<int, ReportStatisticTypeContract> $types Tipos de métricas a calcular.
     * @return ReporteQueryResult
     */
    public function handle(ReporteQuery $dto, array $types): ReporteQueryResult
    {
        return $this->queryOrchestrator->getMultiple($types, $dto);
    }

    /**
     * Contribuye con el conjunto completo de estadísticas de presupuestos.
     *
     * @param ReporteQuery $dto Parámetros de la consulta.
     * @return ReporteQueryResult
     */
    public function contribute(ReporteQuery $dto): ReporteQueryResult
    {
        /** @var array<int, ReportStatisticTypeContract> $types */
        $types = array_values(PresupuestoReportStatisticType::cases());

        return $this->handle($dto, $types);
    }

    /**
     * Determina si este handler debe ejecutarse para los tipos solicitados.
     *
     * @param array<int, ReportStatisticTypeContract> $requestedTypes
     * @return bool
     */
    public function shouldContribute(array $requestedTypes): bool
    {
        return !empty(array_filter(
            $requestedTypes,
            static fn(ReportStatisticTypeContract $type): bool => $type instanceof PresupuestoReportStatisticType
        ));
    }
}
