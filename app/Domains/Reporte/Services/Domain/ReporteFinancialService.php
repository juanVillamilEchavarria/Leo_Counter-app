<?php
namespace App\Domains\Reporte\Services\Domain;

use App\Domains\Reporte\Services\Domain\ReporteQueryService;
use App\Domains\Reporte\DTOs\Budget\UsedBudgetDTO;
use App\Shared\Services\Financial\PercentageService;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;

class ReporteFinancialService {

    public function __construct(
        private ReporteQueryService $reporteQueryService,
        private PercentageService $percentageService
    ){}
      public function getUsedBudget(ReporteQueryDTO $reporteQueryDTO){
        $presupuesto = $this->reporteQueryService->getTotalPresupuesto($reporteQueryDTO);
        $gastos = $this->reporteQueryService->getTotalGastos($reporteQueryDTO);
        $disponible = $gastos < $presupuesto ? $presupuesto - $gastos : 0;
        return new UsedBudgetDTO(
            gastado: $gastos,
            presupuestado: $presupuesto,
            porcentaje_usado:$this->percentageService->calculatePercentage($gastos, $presupuesto),
            disponible:$disponible
            
        );
    }
}
