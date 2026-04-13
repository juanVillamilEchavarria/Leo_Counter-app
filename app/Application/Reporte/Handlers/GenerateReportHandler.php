<?php

namespace App\Application\Reporte\Handlers;

use App\Application\Reporte\DTOs\ReportGenerationDTO;
use App\Application\Reporte\Contracts\ReportContributorContract;
use App\Application\Reporte\Mappers\ReportQueryMapper;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;

/**
 * Handler / Dispacther (use Case) compuesto para realizar la generacion de reportes
 * Responsabilidades:
 * - Es el unico punto de entrada de la aplicacion para generar reportes financieros
 * - Combinar contribuciones de los diferentes dominios para generar el reporte financiero con las estadisticas solicitadas
 *Obtiene todos las posibles estadisticas del sistema, tanto individuales por dominio, multiples por dominio, y multiples por dominio con multiples estadisticas
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class GenerateReportHandler
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
     * Genera el reporte financiero completo combinando las contribuciones que correspondan a los tipos de estadisticas solicitados.
     * Puede generar reportes de diferentes dominios con diferentes estadisticas, de un solo dominio con varias consultas estadisticas, o una sola consulta estadistica de un dominio.
     * Simplemente pasa el tipo o los tipos de estadisticas a consultar a los contribuidores registrados.
     * @param array<int, ReportStatisticTypeContract> $types Tipos de métricas a calcular definidas para cada dominio.
     * @param ReportGenerationDTO $data DTO de entrada desde la capa HTTP.
     * @return ReporteQueryResult - Objeto de salida con los resultados de las contribuciones.
     */

    public function handle(array $types, ReportGenerationDTO $data): ReporteQueryResult{
        $dto = $this->mapper->map($data);
        $result = new ReporteQueryResult();
        /** @param ReportContributorContract $contributor */
        foreach ($this->contributors as $contributor) {
            if($contributor->shouldContribute($types)){
                $result = $result->merge($contributor->handle($dto,$types));
            }
        }
        return $result;
    }

    /**
     * Genera el reporte financiero completo combinando las contribuciones
     * de todos los dominios registrados en el sistema para reportes.
     *
     * @param ReportGenerationDTO $data DTO de entrada desde la capa HTTP.
     * @return ReporteQueryResult
     */
    public function fullReport(ReportGenerationDTO $data): ReporteQueryResult
    {
        $dto = $this->mapper->map($data);
        $result = new ReporteQueryResult();

        foreach ($this->contributors as $contributor) {
            $result = $result->merge($contributor->contribute($dto));
        }

        return $result;
    }
}




