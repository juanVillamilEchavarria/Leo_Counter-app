<?php

namespace App\Application\Reporte\Handlers;

use App\Application\Reporte\DTOs\ReportGenerationDTO;
use App\Application\Reporte\Contracts\ReportContributorContract;
use App\Application\Reporte\Mappers\ReportQueryMapper;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;

/**
 * Handler compuesto responsable de generar el reporte financiero completo.
 * Orquesta a los contribuidores registrados sin conocer detalles de ningún
 * dominio concreto, combinando sus resultados en un único objeto de salida.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class GenerateFullFinancialReportHandler
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
     * @param ReportGenerationDTO $data DTO de entrada desde la capa HTTP.
     * @return ReporteQueryResult
     */
    public function handle(ReportGenerationDTO $data): ReporteQueryResult
    {
        $dto = $this->mapper->map($data);
        $result = new ReporteQueryResult();

        foreach ($this->contributors as $contributor) {
            $result = $result->merge($contributor->contribute($dto));
        }

        return $result;
    }
}
