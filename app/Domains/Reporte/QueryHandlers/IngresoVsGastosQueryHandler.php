<?php
namespace App\Domains\Reporte\QueryHandlers;
use App\Domains\Reporte\Repositories\Contracts\ReporteRepositoryContract;
use App\Domains\Reporte\DTOs\ReporteQueryDTO;
use App\Domains\Reporte\Collections\FinancialPeriodCollection;
use App\Domains\Reporte\DTOs\Promedio\PromedioDTO;
use App\Domains\Reporte\DTOs\IngresosVsGastos\IngresosVsGastosDTO;
class IngresoVsGastosQueryHandler{
    public function apply(ReporteRepositoryContract $reporteRepository, ReporteQueryDTO $reporteQueryDTO){
        $data = $reporteRepository->getIngresosVsGastos($reporteQueryDTO);
        $collection = FinancialPeriodCollection::fromQueryResults($data);
        $promedioDTO = new PromedioDTO(
            ingresos_por_periodo:$collection->ingresosPeriodAverage(),
            gastos_por_periodo:$collection->gastosPeriodAverage(),
            ingresos_por_movimiento:$collection->ingresosIndividualAverage(),
            gastos_por_movimiento:$collection->gastosIndividualAverage()
        );
        return new IngresosVsGastosDTO(
            $collection,
            $promedioDTO
        );
    }
}