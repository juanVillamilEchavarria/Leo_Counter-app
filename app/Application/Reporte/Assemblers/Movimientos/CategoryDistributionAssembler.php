<?php

namespace App\Application\Reporte\Assemblers\Movimientos;

use App\Application\Reporte\Contracts\AssemblerContract;
use App\Application\Reporte\DTOs\Category\FullDistributionCategoryDTO;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Application\Reporte\Assemblers\Abstracts\ReportAssembler;

/**
 * Ensamblador encargado de transformar ReporteQueryResult a FullDistributionCategoryDTO para la capa de presentación.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class CategoryDistributionAssembler extends ReportAssembler implements AssemblerContract
{
    protected ReportStatisticTypeContract $statisticType = MovimientoReportStatisticType::CATEGORY_DISTRIBUTION;
    protected function instanceof(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof MovimientoReportStatisticType ;
         
    }
    protected function buildAssemble(ReporteQueryResult $results): FullDistributionCategoryDTO | null
    {
        /** @var DistributionCategoryCollection*/
       $categoryCollection = $results->get(MovimientoReportStatisticType::CATEGORY_DISTRIBUTION);
            return new FullDistributionCategoryDTO(
                $categoryCollection->toArray(),
                $categoryCollection->totalMovimientos()
            );
    }
}
