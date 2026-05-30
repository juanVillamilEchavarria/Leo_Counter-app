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

use App\Domains\Reporte\Contracts\Collections\Movimientos\BalanceNetoCollectionContract;
use App\Domains\Reporte\ValueObjects\BalanceNeto\BalanceNetoVO;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Implementación Laravel de la colección de balance neto del reporte financiero.
 *
 * @extends LaravelCollection<int, BalanceNetoVO>
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 */
final class LaravelBalanceNetoCollection extends LaravelCollection implements BalanceNetoCollectionContract
{
    public function totalBalance(): float
    {
        return $this->sum(fn(BalanceNetoVO $item) => $item->balance);
    }
}