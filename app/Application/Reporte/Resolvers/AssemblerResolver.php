<?php

namespace App\Application\Reporte\Resolvers;

use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
/**
 * Resolver de ensambladores de reportes
 * Responsabilidades:
 * - Buscar el ensamblador adecuado para el tipo de reporte y el resultado de la consulta
 */
final class AssemblerResolver
{
    public function __construct(private readonly iterable $assemblers) {}

    /**
     * Itera todos los ensambladores y busca el adecuado para el tipo de reporte y el resultado de la consulta
     * 
     * @param ReportStatisticTypeContract $type - el tipo de reporte
     * @param ReporteQueryResult $results - el resultado de la consulta
     * @return mixed - el ensamblaje del reporte
     */
    public function resolve(
        ReportStatisticTypeContract $type,
        ReporteQueryResult $results
    ): mixed
    {
        foreach ($this->assemblers as $assembler) {
            if ($assembler->supports($type)) {
                return $assembler->assemble($results);
            }
        }

        throw new \InvalidArgumentException(
            "No assembler found for type: {$type->value}"
        );
    }
    /**
     * Verifica si existe un ensamblador adecuado para el tipo de reporte
     * 
     * @param ReportStatisticTypeContract $type - el tipo de reporte
     * @return bool
     */

    public function has(ReportStatisticTypeContract $type): bool
    {
        foreach ($this->assemblers as $assembler) {
            if ($assembler->supports($type)) {
                return true;
            }
        }

        return false;
    }
}