<?php

namespace App\Domains\Reporte\DTOs\KPI;

use App\Domains\Reporte\DTOs\Financial\FinancialReportDTO;

class KPIDTO extends FinancialReportDTO{


    public function __construct(float $ingresos, float $gastos, public int $total_movimientos)
    {
         parent::__construct($ingresos, $gastos);
         $this->total_movimientos = $total_movimientos;
    }
}