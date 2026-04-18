<?php

namespace App\Application\Reporte\Queries\Movimientos\KPI;

use App\Shared\Abstracts\DTOs\DTO;

class TotalsKPIDTO extends DTO{

    public function __construct(
        public float $ingresos,
        public float $gastos,
        public float $balance_neto,
        public int $movimientos,
    )
    {
    }
}