<?php

namespace App\Domains\Reporte\Contracts\Collections\Movimientos;
use App\Shared\Domain\Contracts\CollectionContract;
/**
 * Contrato que representa la coleccion de KPIs del reporte financiero basado en movimientos
 * cada item de esta coleccion debe ser una instancia de la clase KPIVO
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @see  App\Domains\Reporte\ValueObjects\KPI\KPIVO
 * 
 */
interface KPICollectionContract extends CollectionContract{
    /**
     * Retorna el monto total de ingresos
     * @return float
     */
     public function totalIngresos(): float;

     /**
      * Retorna el monto total de gastos
      * @return float
      */
    public function totalGastos(): float;

    /**
     * Retorna el monto total de balance neto
     * @return float
     */
    public function totalBalance(): float;

    /**
     * Retorna el total de movimientos
     * @return int
     */
    public function totalMovimientos(): int;
}