<?php

namespace App\Application\Reporte\Support;

use App\Domains\Reporte\Enums\MovimientoReporteQueryType;
use App\Domains\Reporte\Enums\PresupuestoReporteQueryType;
use App\Domains\Reporte\Enums\ReporteRepositoryType;
use App\Domains\Reporte\Contracts\Repositories\ReporteModelRepositoryContract;
use App\Domains\Reporte\ValueObjects\Budget\UsedBudgetVO;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Shared\Domain\Services\Financial\PercentageService;
use App\Domains\Reporte\Services\BudgetService;
use App\Domains\Reporte\Resolvers\ReporteRepositoryResolver;

final class ReporteFinancialService
{
    public function __construct(
        private ReporteRepositoryResolver $repositoryResolver,
        private PercentageService $percentageService,
        private BudgetService $budgetService
    ) {
    }

    public function getUsedBudget(ReporteModelRepositoryContract $movimientoRepository,ReporteQueryDTO $reporteQueryDTO): UsedBudgetVO
    {
        $presupuestoCollection = $this->repositoryResolver->resolve(ReporteRepositoryType::PRESUPUESTOS)->get(PresupuestoReporteQueryType::TOTAL_PRESUPUESTO, $reporteQueryDTO);
        $presupuesto = $presupuestoCollection->getItems()->first();
        $gastosCollection = $movimientoRepository->get(MovimientoReporteQueryType::GASTOS,$reporteQueryDTO);
        /** @var \App\Domains\Reporte\Collections\GastosCollection $gastosCollection */
        $gastos = $gastosCollection->totalMonto();
        $disponible = $this->budgetService->calculateAvailable($gastos, $presupuesto);
        return new UsedBudgetVO(
            gastado: $gastos,
            presupuestado: $presupuesto,
            porcentaje_usado: $this->percentageService->calculatePercentage($gastos, $presupuesto),
            disponible: $disponible
        );
    }
}
