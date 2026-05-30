<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Reporte\Contracts\Collections\Movimientos;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato que representa la coleccion de balance neto (ingresos - gastos) del reporte financiero, el cual esta agrupado por periodos definidos segun la granularidad del reporte
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface BalanceNetoCollectionContract extends CollectionContract {
    /**
     * Obtiene el total del balance neto, sumando el balance neto de todos los periodos de la coleccion
     */
    public function totalBalance(): float;  
}