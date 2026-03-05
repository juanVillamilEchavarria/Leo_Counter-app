<?php

namespace App\Domains\Reporte\DTOs\Financial;
use Illuminate\Support\Carbon;
use App\Domains\Reporte\DTOs\Financial\FinancialReportDTO;

class FinancialMonthDTO extends FinancialReportDTO
{
    public function __construct(
        public string $mes,
        public float $ingresos,
        public float $gastos
    )
    {
        parent::__construct($ingresos, $gastos);
        $this->mes = $mes;
    }

 

    public function getDateFormat(){
        return Carbon::parse($this->mes)->format('Y-m');
    }

   public function toArray()
   {
    return array_merge(parent::toArray(),[
        'balance'=> $this->getBalance()
    ]);
   }
}