<?php

namespace App\Application\Reporte\Assemblers\Movimientos;

use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;

/**
 * Ensamblador encargado de transformar ReporteQueryResult al formato de balance para la capa de presentación.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final class BalanceNetoAssembler
{
    public function assemble(ReporteQueryResult $results): mixed 
    {
        if(!$results->has(MovimientoReportStatisticType::BALANCE_NETO)){
            return null;
        }
        return $results->get(MovimientoReportStatisticType::BALANCE_NETO);
    }

}
