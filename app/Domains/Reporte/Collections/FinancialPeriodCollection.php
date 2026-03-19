<?php

namespace App\Domains\Reporte\Collections;

use Illuminate\Support\Collection;
use App\Domains\Reporte\DTOs\Financial\FinancialPeriodDTO;
use App\Domains\Reporte\Builders\FinancialPeriodBuilder;

class FinancialPeriodCollection extends Collection {
    public static function fromQueryResults(Collection $queryResults){
        return new self(FinancialPeriodBuilder::fromQueryResults($queryResults));
    }

   /**
    * Promedio de ingresos por periodo, es decir monto de ingresos / Numero de periodos
    */
    public function ingresosPeriodAverage(){
        return $this->avg(fn(FinancialPeriodDTO $mes) => $mes->ingresos);
    }
    /**
     * Promedio de gastos por periodo, es decir monto de gastos / Numero de periodos
     */

    public function gastosPeriodAverage(){
        return $this->avg(fn(FinancialPeriodDTO $mes) => $mes->gastos);
    }

    /**
     * Promedio total de ingresos, es decir Monto de ingresos / Numero de movimientos tipo ingreso
     */
    public function ingresosIndividualAverage(){

        $totalIngresos = $this->totalIngresos();
        $totalIngresosCount = $this->totalIngresosCount();
        return $totalIngresosCount > 0 ? $totalIngresos / $totalIngresosCount : 0;
    }
    /**
     * Promedio total de gastos, es decir Monto de gastos / Numero de movimientos tipo gasto
     */

    public function gastosIndividualAverage(){
        $totalGastos = $this->totalGastos();
        $totalGastosCount = $this->totalGastosCount();
        return $totalGastosCount > 0 ? $totalGastos / $totalGastosCount : 0;
    }
        private function totalIngresos(){
        return $this->sum(fn(FinancialPeriodDTO $mes) => $mes->ingresos);
    }
    private function totalGastos(){
        return $this->sum(fn(FinancialPeriodDTO $mes) => $mes->gastos);
    }

    private function totalIngresosCount(){
        return $this->sum(fn(FinancialPeriodDTO $mes) => $mes->count_ingresos);
    }

    private function totalGastosCount(){
        return $this->sum(fn(FinancialPeriodDTO $mes) => $mes->count_gastos);
    }
    


}