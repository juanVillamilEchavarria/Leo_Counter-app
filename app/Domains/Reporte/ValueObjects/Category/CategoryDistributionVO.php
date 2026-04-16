<?php

namespace App\Domains\Reporte\ValueObjects\Category;

/**
 * Value Object que representa una distribucion de categorias por movimientos en un periodo determinado, agrupados por categorias
 * Ejempo de representacion: se piden 3 categorias (comida, entretenimiento e ingresos laborales), cada una de estas, debe ser representada por una instancia de esta clase
 * Con base a esta clase, se construye el collection de distribucion de categorias
 */ 
final class CategoryDistributionVO
{
    /**
     * @param string $categoria - Nombre de la categoria
     * @param int $cantidad - Cantidad de movimientos asociados
     * @param int $tipo_movimiento_id - Id del tipo de movimiento [pensado de esta manera para filtrado dinamico]
     * @param float $total - Total de la categoria
     */
    public function __construct(
        public string $categoria,
        public int $cantidad,
        public int $tipo_movimiento_id,
        public float $total
    ) {
    }
}
