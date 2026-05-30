<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Collections\Laravel\Movimientos;

use App\Domains\Reporte\Contracts\Collections\Movimientos\IncomeExpenseCollectionContract;
use App\Domains\Reporte\ValueObjects\Financial\IncomeExpensePeriodVO;
use App\Shared\Domain\Services\Financial\AverageService;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Implementación Laravel de la colección de ingresos y gastos por periodo del reporte financiero.
 *
 * @extends LaravelCollection<int, IncomeExpensePeriodVO>
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 */
final class LaravelIncomeExpenseCollection extends LaravelCollection implements IncomeExpenseCollectionContract
{
    /**
     * Promedio de ingresos por periodo, es decir monto de ingresos / Numero de periodos
     */
    public function ingresosPeriodAverage(): ?float
    {
        return $this->avg(fn(IncomeExpensePeriodVO $mes) => $mes->ingresos);
    }

    /**
     * Promedio de gastos por periodo, es decir monto de gastos / Numero de periodos
     */
    public function gastosPeriodAverage(): ?float
    {
        return $this->avg(fn(IncomeExpensePeriodVO $mes) => $mes->gastos);
    }

    /**
     * Promedio total de ingresos, es decir Monto de ingresos / Numero de movimientos tipo ingreso
     */
    public function ingresosIndividualAverage(): ?float
    {
        $totalIngresos = $this->totalIngresos();
        $totalIngresosCount = $this->totalIngresosCount();
        return AverageService::average($totalIngresos, $totalIngresosCount);
    }

    /**
     * Promedio total de gastos, es decir Monto de gastos / Numero de movimientos tipo gasto
     */
    public function gastosIndividualAverage(): ?float
    {
        $totalGastos = $this->totalGastos();
        $totalGastosCount = $this->totalGastosCount();
        return AverageService::average($totalGastos, $totalGastosCount);
    }

    private function totalIngresos(): ?float
    {
        return $this->sum(fn(IncomeExpensePeriodVO $mes) => $mes->ingresos);
    }

    private function totalGastos(): ?float
    {
        return $this->sum(fn(IncomeExpensePeriodVO $mes) => $mes->gastos);
    }

    private function totalIngresosCount(): ?int
    {
        return $this->sum(fn(IncomeExpensePeriodVO $mes) => $mes->count_ingresos);
    }

    private function totalGastosCount(): ?int
    {
        return $this->sum(fn(IncomeExpensePeriodVO $mes) => $mes->count_gastos);
    }
}