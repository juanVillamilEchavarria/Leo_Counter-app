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

use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelCategoryDistributionCollection;
use App\Domains\Reporte\Contracts\Collections\Movimientos\CategoryDistributionCollectionContract;
use App\Domains\Reporte\ValueObjects\Category\CategoryDistributionVO;
use Illuminate\Support\Collection as LaravelCollection;

final class EloquentCategoryDistributionBuilder
{
    public static function buildCollection(LaravelCollection $rows): LaravelCategoryDistributionCollection
    {
        $items = $rows->map(static function ($row) {
            return new CategoryDistributionVO(
                (string) $row->categoria,
                (int) $row->cantidad,
                (int) $row->tipo_movimiento_id,
                (float) $row->total
            );
        });

        return LaravelCategoryDistributionCollection::make($items);
    }
}
