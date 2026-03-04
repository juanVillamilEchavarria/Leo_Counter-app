<?php

namespace App\Domains\Reporte\Builders;

use App\Domains\Reporte\DTOs\KPIDTO;
use Illuminate\Support\Collection;

class KPIBuilder{

    public static function fromQueryResults(Collection $queryResults){
        return $queryResults->map(function($movimiento) {
            return $this->build($movimiento);
        })->values();

    }

    private function build(\stdClass $movimiento){
        return new KPIDTO(
            $movimiento->total_ingresos,
            $movimiento->total_gastos,
            $movimiento->total_movimientos
        );
    }

}