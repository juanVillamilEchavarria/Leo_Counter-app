<?php

namespace App\Application\Reporte\Handlers;

use App\Application\Reporte\Queries\GenerateFinancialReportQuery;
use App\Application\Reporte\Contracts\ReportContributorContract;
use App\Application\Reporte\Mappers\ReportQueryMapper;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;

/**
 * Handler / Dispacther (use Case) compuesto para realizar el reporte completo
 * Responsabilidades:
 * - Combinar contribuciones de los diferentes dominios para generar el reporte financiero con todas las estadisticas de todos los dominios.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GenerateFullReportHandler
{
    /**
     * @param ReportQueryMapper $mapper Transforma el DTO de entrada al Value Object de dominio.
     * @param iterable<int, ReportContributorContract> $contributors Contribuidores registrados en el contenedor.
     */
    public function __construct(
        private readonly ReportQueryMapper $mapper,
        private readonly iterable $contributors,
    ) {
    }

    /**
     * Genera el reporte financiero completo combinando las contribuciones
     * de todos los dominios registrados en el sistema para reportes.
     *
     * @param GenerateFinancialReportQuery $data DTO de entrada desde la capa HTTP.
     * @return ReporteQueryResult
     */
    public function __invoke(GenerateFinancialReportQuery $data): ReporteQueryResult
    {
        $dto = $this->mapper->map($data);
        $result = new ReporteQueryResult();

        foreach ($this->contributors as $contributor) {
            $result = $result->merge($contributor->contribute($dto));
        }

        return $result;
    }
}




