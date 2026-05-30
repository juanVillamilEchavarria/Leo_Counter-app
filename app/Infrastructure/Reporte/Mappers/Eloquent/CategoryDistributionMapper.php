<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Reporte\Mappers\Eloquent;
use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelCategoryDistributionCollection;
use App\Domains\Reporte\Contracts\Collections\Movimientos\CategoryDistributionCollectionContract;
use App\Domains\Reporte\ValueObjects\Category\CategoryDistributionVO;
use Illuminate\Support\Collection;

/**
 * Mapper usado en las consultas de eloquent, para mappear los resultados de la base de datos a colecciones declaradas por el dominio, en este caso para la collección de distribución por categoría.
 * Se instancia un LaravelCollection que satisface el contrato de coleccion declarado por el dominio
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 * @see App\Domains\Reporte\Contracts\Collections\Movimientos\CategoryDistributionCollectionContract
 * @see use App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelCategoryDistributionCollection
 */
final class CategoryDistributionMapper
{
    public function map(Collection $rows): CategoryDistributionCollectionContract
    {
        $mapped = $rows->map(static function ($row) {
            return new CategoryDistributionVO(
                (string) $row->categoria,
                (int) $row->cantidad,
                (int) $row->tipo_movimiento_id,
                (float) $row->total
            );
        });

        return LaravelCategoryDistributionCollection::make($mapped);
    }
}
