<?php

namespace App\Application\Reporte\DTOs\Financial;
use App\Application\Reporte\DTOs\Financial\FinancialReportDTO;

class FinancialPeriodDTO extends FinancialReportDTO
{
    public function __construct(
        public string $period,
        public float $ingresos,
        public float $gastos,
        public int $count_ingresos,
        public int $count_gastos
    )
    {
        parent::__construct($ingresos, $gastos);
        $this->period = $period;
        $this->count_ingresos = $count_ingresos;
        $this->count_gastos = $count_gastos;
    }


   public function toArray() : array
   {
    return array_merge(parent::toArray(),[
        'balance'=> $this->getBalance()
    ]);
   }

}