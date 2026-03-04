<?php

namespace App\Domains\Reporte\Builders;

use App\Domains\Reporte\DTOs\FinancialMonthDTO;
use Illuminate\Support\Collection;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

class FinancialMonthBuilder{
    public static function buildFromQueryResults(Collection $queryResults){
        return $queryResults->map(function($movimiento) use (&$ingresos, &$gastos){
            return $this->build($movimiento);
        })->values();
    }

    private function build(\stdClass $movimeinto){
        return new FinancialMonthDTO($movimeinto->fecha, $movimeinto->ingresos, $movimeinto->gastos);
    }
}