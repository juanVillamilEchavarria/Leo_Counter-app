<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Reporte\Contracts\Collections\Presupuestos;
use App\Shared\Domain\Contracts\CollectionContract;

interface UsedBudgetCollectionContract extends CollectionContract{
    public function totalPresupuesto(): float;
    public function totalGastos(): float;
    public function disponible(): float;
    public function percentageUsed(): float;
}