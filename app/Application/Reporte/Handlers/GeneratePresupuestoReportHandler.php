<?php

namespace App\Application\Reporte\Handlers;

use App\Application\Reporte\Contracts\ReportContributorContract;
use App\Domains\Reporte\Enums\Statistic\PresupuestoReportStatisticType;
use App\Domains\Reporte\Enums\Domains\DomainReportQueryType;
use App\Domains\Reporte\Resolvers\ReporteQueryPortResolver;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
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
final class GeneratePresupuestoReportHandler implements ReportContributorContract
{
    /**
     * @param ReporteQueryPortResolver $repositoryResolver Resolver de repositorios de reportes.
     */
    public function __construct(
        private readonly ReporteQueryPortResolver $repositoryResolver,
    ) {
    }

    /**
     * Genera estadísticas de presupuestos para los tipos especificados.
     *
     * @param ReporteQueryDTO $dto Parámetros de la consulta.
     * @param array<int, ReportStatisticTypeContract> $types Tipos de métricas a calcular.
     * @return ReporteQueryResult
     */
    public function handle(ReporteQueryDTO $dto, array $types): ReporteQueryResult
    {
        $repository = $this->repositoryResolver->resolve(DomainReportQueryType::PRESUPUESTOS);

        return $repository->getMultiple($types, $dto);
    }

    /**
     * Contribuye con el conjunto completo de estadísticas de presupuestos.
     *
     * @param ReporteQueryDTO $dto Parámetros de la consulta.
     * @return ReporteQueryResult
     */
    public function contribute(ReporteQueryDTO $dto): ReporteQueryResult
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
