<?php

namespace App\Application\Reporte\Assemblers\Presupuestos;

use App\Application\Reporte\Contracts\AssemblerContract;
use App\Application\Reporte\DTOs\Presupuestos\Used\UsedBudgetDTO;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\Enums\Statistic\PresupuestoReportStatisticType;
use App\Domains\Reporte\ValueObjects\Budget\UsedBudgetVO;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Shared\Domain\Services\Financial\PercentageService;
use App\Application\Reporte\Assemblers\Abstracts\ReportAssembler;

/**
 * Ensamblador encargado de transformar ReporteQueryResult a UsedBudgetDTO para la capa de presentación.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class UsedBudgetAssembler extends ReportAssembler implements AssemblerContract
{
    protected ReportStatisticTypeContract $statisticType = PresupuestoReportStatisticType::USED_BUDGET; 
    public function __construct(
        private readonly PercentageService $percentageService
    ) {}

    protected function instanceof(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof PresupuestoReportStatisticType ;
    }

    protected function buildAssemble(ReporteQueryResult $results): ?UsedBudgetDTO
    {
        /** @var UsedBudgetVO $vo */
        $vo = $results->get(PresupuestoReportStatisticType::USED_BUDGET);

        return new UsedBudgetDTO(
            gastado: $vo->total_gastos,
            presupuestado: $vo->total_presupuesto,
            disponible: $vo->disponible,
            porcentaje_usado: $vo->percentageUsed()
        );
    }
}
