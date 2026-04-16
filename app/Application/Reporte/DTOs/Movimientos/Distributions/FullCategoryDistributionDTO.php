<?php

namespace App\Application\Reporte\DTOs\Movimientos\Distributions;


use App\Shared\Abstracts\DTOs\DTO;
use App\Domains\Reporte\ValueObjects\Category\CategoryDistributionVO;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Domains\Reporte\Contracts\Collections\Movimientos\CategoryDistributionCollectionContract;
/**
 * DTO para representar la distribución completa de categorías en un periodo específico.
 * Este objeto es quien se ensamblara a partir del CategoryDistributionCollection para ser consumido por la capa de presentación.
 * Contiene una colección con la distribución de categorías agrupadas por periodo y el total de movimientos en ese periodo.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 * @see App\Domains\Reporte\ValueObjects\Category\CategoryDistributionVO - la colección de este DTO, debe ser una colección de este Value Object
 * @see App\Application\Reporte\Assemblers\Movimientos\CategoryDistributionAssembler - Ensamblador de este DTO
 */
final class FullCategoryDistributionDTO extends DTO{

    /**
     * @param CategoryDistributionCollectionContract $data - Distribucion de categorias agrupadas por periodo
     */
    public function __construct(
        public readonly CategoryDistributionCollectionContract $data,
        public readonly int $total_movimientos
    )
    {
    }

}
