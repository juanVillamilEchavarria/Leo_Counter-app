<?php

namespace App\Domains\Reporte\Collections;

use App\Domains\Reporte\ValueObjects\Financial\FinancialPeriodVO;
use App\Shared\Domain\Collections\DomainCollection;
use App\Shared\Domain\Services\Financial\AverageService;
use Illuminate\Support\Collection;

class FinancialPeriodCollection extends DomainCollection
{

    public function __construct(array|Collection $collection = [])
    {
        return parent::__construct($collection);
    }
   /**
    * Promedio de ingresos por periodo, es decir monto de ingresos / Numero de periodos
    */
    public function ingresosPeriodAverage(): float
    {
        return $this->avg(fn(FinancialPeriodVO $mes) => $mes->ingresos);
    }
    /**
     * Promedio de gastos por periodo, es decir monto de gastos / Numero de periodos
     */

    public function gastosPeriodAverage(): float
    {
        return $this->avg(fn(FinancialPeriodVO $mes) => $mes->gastos);
    }

    /**
     * Promedio total de ingresos, es decir Monto de ingresos / Numero de movimientos tipo ingreso
     */
    public function ingresosIndividualAverage(): float{

        $totalIngresos = $this->totalIngresos();
        $totalIngresosCount = $this->totalIngresosCount();
        return AverageService::average($totalIngresos, $totalIngresosCount);
    }
    /**
     * Promedio total de gastos, es decir Monto de gastos / Numero de movimientos tipo gasto
     */

    public function gastosIndividualAverage(): float{
        $totalGastos = $this->totalGastos();
        $totalGastosCount = $this->totalGastosCount();
        return AverageService::average($totalGastos, $totalGastosCount);
    }
        private function totalIngresos(): float
    {
        return $this->sum(fn(FinancialPeriodVO $mes) => $mes->ingresos);
    }

    private function totalGastos(): float
    {
        return $this->sum(fn(FinancialPeriodVO $mes) => $mes->gastos);
    }

    private function totalIngresosCount(): int
    {
        return $this->sum(fn(FinancialPeriodVO $mes) => $mes->count_ingresos);
    }

    private function totalGastosCount(): int
    {
        return $this->sum(fn(FinancialPeriodVO $mes) => $mes->count_gastos);
    }
    


}