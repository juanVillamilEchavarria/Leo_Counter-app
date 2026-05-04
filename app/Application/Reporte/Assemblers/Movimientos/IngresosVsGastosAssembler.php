<?php

namespace App\Application\Reporte\Assemblers\Movimientos;

use App\Application\Reporte\Contracts\AssemblerContract;
use App\Application\Reporte\DTOs\Movimientos\Comparatives\IngresosVsGastosDTO;
use App\Application\Reporte\DTOs\Movimientos\Averages\PromedioDTO;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Application\Reporte\Assemblers\Abstracts\ReportAssembler;

/**
 * Ensamblador encargado de transformar ReporteQueryResult a IngresosVsGastosDTO para la capa de presentación.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class IngresosVsGastosAssembler extends ReportAssembler implements AssemblerContract
{
    protected ReportStatisticTypeContract $statisticType = MovimientoReportStatisticType::INGRESOS_VS_GASTOS;
    protected function instanceof(ReportStatisticTypeContract $type): bool
    {
        return $type instanceof MovimientoReportStatisticType ;
    }

    protected function buildAssemble(ReporteQueryResult $results): IngresosVsGastosDTO
    {
        $data = $results->get(MovimientoReportStatisticType::INGRESOS_VS_GASTOS);
        $promedios = new PromedioDTO(
                ingresos_por_periodo: $data->ingresosPeriodAverage(),
                gastos_por_periodo: $data->gastosPeriodAverage(),
                ingresos_por_movimiento: $data->ingresosIndividualAverage(),
                gastos_por_movimiento: $data->gastosIndividualAverage()
        );
        return new IngresosVsGastosDTO(
            data: $data,
            promedios:$promedios
        );
    }
}
