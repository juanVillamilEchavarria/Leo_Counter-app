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

use App\Domains\Reporte\Contracts\Collections\Movimientos\CategoryDistributionCollectionContract;
use App\Domains\Reporte\ValueObjects\Category\CategoryDistributionVO;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Implementación Laravel de la colección de distribución por categorías del reporte financiero.
 *
 * @extends LaravelCollection<int, CategoryDistributionVO>
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 */
final class LaravelCategoryDistributionCollection extends LaravelCollection implements CategoryDistributionCollectionContract
{
    public function totalMovimientos(): int
    {
        return $this->sum(fn(CategoryDistributionVO $mes) => $mes->cantidad);
    }
}