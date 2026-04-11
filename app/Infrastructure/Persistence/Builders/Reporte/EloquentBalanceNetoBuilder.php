<?php

namespace App\Infrastructure\Persistence\Builders\Reporte;

use App\Domains\Reporte\Collections\BalanceNetoCollection;
use App\Domains\Reporte\ValueObjects\BalanceNeto\BalanceNetoVO;
use Illuminate\Support\Collection as LaravelCollection;

final class EloquentBalanceNetoBuilder
{
    public static function buildCollection(LaravelCollection $rows): BalanceNetoCollection
    {
        $items = $rows->map(static function ($row) {
            return new BalanceNetoVO(
                (float) $row->balance,
                (string) $row->fecha
            );
        });

        return BalanceNetoCollection::make($items);
    }
}
