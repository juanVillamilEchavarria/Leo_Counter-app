<?php

namespace App\Domains\Reporte\DTOs;

use App\Shared\Abstracts\DTOs\DTO;

abstract class FinancialReportDTO extends DTO{
    public function __construct(
        public float $ingresos,
        public float $gastos
    )
    {
    }
       public function getBalance(){
        return $this->ingresos - $this->gastos;
    }
}