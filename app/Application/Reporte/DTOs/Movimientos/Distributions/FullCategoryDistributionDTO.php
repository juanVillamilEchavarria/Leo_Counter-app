<?php

namespace App\Application\Reporte\DTOs\Movimientos\Distributions;


use App\Application\Reporte\Assemblers\Movimientos\CategoryDistributionAssembler;
use App\Domains\Reporte\Contracts\Collections\Movimientos\CategoryDistributionCollectionContract;
use App\Domains\Reporte\ValueObjects\Category\CategoryDistributionVO;

/**
 * DTO para representar la distribución completa de categorías en un periodo específico.
 * Este objeto es quien se ensamblara a partir del CategoryDistributionCollection para ser consumido por la capa de presentación.
 * Contiene una colección con la distribución de categorías agrupadas por periodo y el total de movimientos en ese periodo.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 * @see CategoryDistributionVO - la colección de este DTO, debe ser una colección de este Value Object
 * @see CategoryDistributionAssembler - Ensamblador de este DTO
 */
final readonly class FullCategoryDistributionDTO {

    /**
     * @param CategoryDistributionCollectionContract $data - Distribucion de categorias agrupadas por periodo
     */
    public function __construct(
        public  CategoryDistributionCollectionContract $data,
        public  int $total_movimientos
    )
    {
    }

}
