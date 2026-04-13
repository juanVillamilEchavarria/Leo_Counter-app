<?php

namespace App\Infrastructure\Reporte\Collections\Laravel\Movimientos;

use App\Domains\Reporte\Contracts\Collections\Movimientos\CategoryDistributionCollectionContract;
use App\Domains\Reporte\ValueObjects\Category\DistributionCategoryVO;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Implementación Laravel de la colección de distribución por categorías del reporte financiero.
 *
 * @extends LaravelCollection<int, DistributionCategoryVO>
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 */
final class LaravelCategoryDistributionCollection extends LaravelCollection implements CategoryDistributionCollectionContract
{
    public function totalMovimientos(): int
    {
        return $this->sum(fn(DistributionCategoryVO $mes) => $mes->cantidad);
    }
}