<?php

namespace App\Domains\Reporte\Collections;

use Illuminate\Support\Collection;
use App\Domains\Reporte\DTOs\Financial\FinancialMonthDTO;
use App\Domains\Reporte\Builders\FinancialMonthBuilder;

class FinancialMonthCollection extends Collection {
    public static function fromQueryResults(Collection $queryResults){
        return new self(FinancialMonthBuilder::fromQueryResults($queryResults));
    }

   
    public function promedioIngresos(){
        return $this->avg(fn(FinancialMonthDTO $mes) => $mes->ingresos);
    }

    public function promedioGastos(){
        return $this->avg(fn(FinancialMonthDTO $mes) => $mes->gastos);
    }
    


}