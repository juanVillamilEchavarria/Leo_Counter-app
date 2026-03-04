<?php

namespace App\Domains\Reporte\Collections;
use Illuminate\Support\Collection;
use App\Domains\Reporte\Builders\KPIBuilder;
use App\Domains\Reporte\DTOs\KPIDTO;

class KPICollection extends Collection{
    public static function fromQueryResults(Collection $queryResults){
        return new self(KPIBuilder::fromQueryResults($queryResults));
    }
     public function totalIngresos(){
        return $this->sum(fn(KPIDTO $mes) => $mes->ingresos);
    }

    public function totalGastos(){
        return $this->sum(fn(KPIDTO $mes) => $mes->gastos);
    }


    public function totalBalance(){
        return $this->sum(fn(KPIDTO $mes) => $mes->getBalance());
    }

    public function totalMovimientos(){
        return $this->sum(fn(KPIDTO $mes) => $mes->total_movimientos);
    }

}