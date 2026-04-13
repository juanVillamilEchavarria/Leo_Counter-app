<?php
namespace App\Domains\Reporte\Contracts\Collections\Movimientos;
use App\Shared\Domain\Contracts\CollectionContract;


/**
 * Contrato que representa la coleccion de datos estadisticos de ingresos y gastos definidos por periodo del reporte financiero
 * cada periodo de la coleccion debe ser una instancia de la clase IncomeExpensePeriodVO
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @see App\Domains\Reporte\ValueObjects\Financial\IncomeExpensePeriodVO
 */
interface IncomeExpenseCollectionContract extends CollectionContract {
    /**
    * Promedio de ingresos por periodo, es decir monto de ingresos / Numero de periodos
    */
    public function ingresosPeriodAverage(): float;
    
    /**
     * Promedio de gastos por periodo, es decir monto de gastos / Numero de periodos
     */

    public function gastosPeriodAverage(): float;
    

    /**
     * Promedio total de ingresos, es decir Monto de ingresos / Numero de movimientos tipo ingreso
     */
    public function ingresosIndividualAverage(): float;
    /**
     * Promedio total de gastos, es decir Monto de gastos / Numero de movimientos tipo gasto
     */

    public function gastosIndividualAverage(): float;
}