<?php

namespace App\Domains\Reporte\DTOs\Financial;
use Illuminate\Support\Carbon;
use App\Domains\Reporte\DTOs\Financial\FinancialReportDTO;

class FinancialPeriodDTO extends FinancialReportDTO
{
    public function __construct(
        public string $period,
        public float $ingresos,
        public float $gastos
    )
    {
        parent::__construct($ingresos, $gastos);
        $this->period = $period;
    }

   public function toArray()
   {
    return array_merge(parent::toArray(),[
        'balance'=> $this->getBalance()
    ]);
   }
}