<?php

namespace App\Domains\Reporte\Collections;

use Illuminate\Support\Collection;
use App\Domains\Reporte\DTOs\Financial\FinancialPeriodDTO;
use App\Domains\Reporte\Builders\FinancialPeriodBuilder;

class FinancialPeriodCollection extends Collection {
    public static function fromQueryResults(Collection $queryResults){
        return new self(FinancialPeriodBuilder::fromQueryResults($queryResults));
    }

   
    public function promedioIngresos(){
        return $this->avg(fn(FinancialPeriodDTO $mes) => $mes->ingresos);
    }

    public function promedioGastos(){
        return $this->avg(fn(FinancialPeriodDTO $mes) => $mes->gastos);
    }
    


}