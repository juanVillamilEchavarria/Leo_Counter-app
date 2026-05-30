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

use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelIncomeExpenseCollection;
use App\Domains\Reporte\Contracts\Collections\Movimientos\IncomeExpenseCollectionContract;
use App\Domains\Reporte\ValueObjects\Financial\IncomeExpensePeriodVO;
use Illuminate\Support\Collection as LaravelCollection;

final class EloquentFinancialPeriodBuilder
{
    public static function buildCollection(LaravelCollection $rows): LaravelIncomeExpenseCollection
    {
        $items = $rows->map(static function ($row) {
            return new IncomeExpensePeriodVO(
                (string) $row->fecha,
                (float) $row->ingresos,
                (float) $row->gastos,
                (int) $row->count_ingresos,
                (int) $row->count_gastos
            );
        });

        return LaravelIncomeExpenseCollection::make($items);
    }
}
