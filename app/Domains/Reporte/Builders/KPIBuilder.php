<?php

namespace App\Domains\Reporte\Builders;

use App\Domains\Reporte\DTOs\KPI\KPIDTO;
use Illuminate\Support\Collection;

class KPIBuilder{

    public static function fromQueryResults(Collection $queryResults){
        return $queryResults->map(function($movimiento) {
            return self::build($movimiento);
        })->values();

    }

    private static function build(\stdClass $movimiento){
        return new KPIDTO(
            $movimiento->total_ingresos,
            $movimiento->total_gastos,
            $movimiento->total_movimientos
        );
    }

}