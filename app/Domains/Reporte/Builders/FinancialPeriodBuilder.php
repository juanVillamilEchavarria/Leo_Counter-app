<?php

namespace App\Domains\Reporte\Builders;

use App\Domains\Reporte\DTOs\Financial\FinancialPeriodDTO;
use Illuminate\Support\Collection;

class FinancialPeriodBuilder{
    public static function fromQueryResults(Collection $queryResults){
        return $queryResults->map(function($movimiento) use (&$ingresos, &$gastos){
            return self::build($movimiento);
        })->values();
    }

    private static function build(\stdClass $movimeinto){
        return new FinancialPeriodDTO($movimeinto->fecha, $movimeinto->ingresos, $movimeinto->gastos);
    }
}