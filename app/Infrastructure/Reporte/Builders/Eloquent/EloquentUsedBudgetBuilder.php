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

use App\Domains\Reporte\ValueObjects\Budget\UsedBudgetVO;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use App\Domains\Reporte\Contracts\Collections\Presupuestos\UsedBudgetCollectionContract;
use App\Infrastructure\Reporte\Collections\Laravel\Presupuestos\LaravelUsedBudgetCollection;

final class EloquentUsedBudgetBuilder
{
    public static function build(LaravelCollection $rows): UsedBudgetCollectionContract
    {
        $items = $rows->map(static function ($row) {
            $vo = new UsedBudgetVO(
                categoria: (string) $row->categoria,
                presupuestado: (float) $row->total_presupuesto,
                gastado: (float) $row->total_gastos,
                disponible: $row->disponible < 0 ? (float) 0 : (float) $row->disponible
            );
            return $vo;
            
        });

        return LaravelUsedBudgetCollection::make($items);
    }
}