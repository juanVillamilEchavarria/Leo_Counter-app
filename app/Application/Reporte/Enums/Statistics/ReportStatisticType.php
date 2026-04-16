<?php

namespace App\Application\Reporte\Enums\Statistics;


use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\Enums\Statistic\PresupuestoReportStatisticType;


/**
 * Enum encargado de definir las estadisticas permitidas en la interfaz de reportes.
 * 
 * Debe ser llamado a la hora de pedir las estadisticas de la interfaz de reporte en el handler GenerateReportHandler.
 * 
 * Ejemplo: en el controller para la interfaz, en un metodo getReport() simplemete llamas al handler, y en la funcion de handle() le pasas el ReportStatisticType::statistics() como parametro para pedir todas las estadisticas definidas en este enum
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @see  App\Application\Reporte\Handlers\GenerateReportHandler
 */ 
enum ReportStatisticType : string implements ReportStatisticTypeContract{

    /**
     * Retorna un array con todas las estadisticas que se desean mostrar en la interfaz de reportes.
     * 
     * @return array<string, ReportStatisticTypeContract>
     */
    public static function statistics() : array{
        return [
            MovimientoReportStatisticType::CATEGORY_DISTRIBUTION,
            MovimientoReportStatisticType::INGRESOS_VS_GASTOS,
            MovimientoReportStatisticType::KPIS,
            MovimientoReportStatisticType::BALANCE_NETO,
            PresupuestoReportStatisticType::USED_BUDGET
        ];
    }
}