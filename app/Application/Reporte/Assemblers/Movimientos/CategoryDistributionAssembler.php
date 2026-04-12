<?php

namespace App\Application\Reporte\Assemblers\Movimientos;

use App\Application\Reporte\DTOs\Category\FullDistributionCategoryDTO;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;

/**
 * Ensamblador encargado de transformar ReporteQueryResult a FullDistributionCategoryDTO para la capa de presentación.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class CategoryDistributionAssembler
{
    public function assemble(ReporteQueryResult $results): FullDistributionCategoryDTO | null
    {
        if(!$results->has(MovimientoReportStatisticType::CATEGORY_DISTRIBUTION)){
            return null;
        }
       $categoryCollection = $results->get(MovimientoReportStatisticType::CATEGORY_DISTRIBUTION);
            return new FullDistributionCategoryDTO(
                $categoryCollection,
                $categoryCollection->totalMovimientos()
            );
    }

}
