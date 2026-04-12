<?php

namespace App\Application\Reporte\Assemblers\Presupuestos;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\Enums\Statistic\PresupuestoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Application\Reporte\DTOs\Budget\UsedBudgetDTO;
use App\Domains\Reporte\Services\BudgetService;
use App\Shared\Domain\Services\Financial\PercentageService;

/**
 * Ensamblador encargado de transformar ReporteQueryResult a UsedBudgetDTO para la capa de presentación.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class UsedBudgetAssembler
{
    public function __construct(
        private BudgetService $budgetService,
        private PercentageService $percentageService
    )
    {
    }
    public function assemble(ReporteQueryResult $results): UsedBudgetDTO | null
    {
        if(!$results->has(MovimientoReportStatisticType::GASTOS) || !$results->has(PresupuestoReportStatisticType::TOTAL_PRESUPUESTO)){
            return null;
        }
       $total_presupuesto = $results->get(PresupuestoReportStatisticType::TOTAL_PRESUPUESTO);
       $gastos = $results->get(MovimientoReportStatisticType::GASTOS);
       $disponible = $this->budgetService->calculateAvailable($gastos, $total_presupuesto);
       $porcentaje = $this->percentageService->calculatePercentage($gastos, $total_presupuesto);
       return new UsedBudgetDTO(
           gastado: $gastos,
           presupuestado: $total_presupuesto,
           disponible: $disponible,
           porcentaje_usado: $porcentaje);

    }

}
