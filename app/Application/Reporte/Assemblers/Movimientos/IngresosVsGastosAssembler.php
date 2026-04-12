<?php

namespace App\Application\Reporte\Assemblers\Movimientos;

use App\Application\Reporte\DTOs\IngresosVsGastos\IngresosVsGastosDTO;
use App\Application\Reporte\DTOs\Promedio\PromedioDTO;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;

/**
 * Ensamblador encargado de transformar ReporteQueryResult a IngresosVsGastosDTO para la capa de presentación.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class IngresosVsGastosAssembler
{
    public function assemble(ReporteQueryResult $results): IngresosVsGastosDTO | null
    {
        if(!$results->has(MovimientoReportStatisticType::INGRESOS_VS_GASTOS)){
            return null;
        }
        
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
