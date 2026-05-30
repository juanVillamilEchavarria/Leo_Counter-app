<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Reporte\Contracts\Collections\Movimientos;
use App\Shared\Domain\Contracts\CollectionContract;
/**
 * Contrato que representa la coleccion de distribucion de categorias en base a movimientos , agrupando por tipo de movimiento en un periodo determinado
 * las implementaciones de este contrato deben ser una coleccion de instancias de la clase  CategoryDistributionVO
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @see App\Domains\Reporte\ValueObjects\Category\CategoryDistributionVO
 */
interface CategoryDistributionCollectionContract extends CollectionContract {
    /**
     * Obtiene el total de movimientos de la coleccion
     */
    public function totalMovimientos(): int;
}