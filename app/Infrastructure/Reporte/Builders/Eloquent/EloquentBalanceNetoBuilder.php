<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Builders\Eloquent;

use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelBalanceNetoCollection;
use App\Domains\Reporte\ValueObjects\BalanceNeto\BalanceNetoVO;
use Illuminate\Support\Collection as LaravelCollection;

final class EloquentBalanceNetoBuilder
{
    public static function buildCollection(LaravelCollection $rows): LaravelBalanceNetoCollection
    {
        $items = $rows->map(static function ($row) {
            return new BalanceNetoVO(
                (float) $row->balance,
                (string) $row->fecha
            );
        });

        return LaravelBalanceNetoCollection::make($items);
    }
}
