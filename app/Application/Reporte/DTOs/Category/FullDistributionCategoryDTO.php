<?php

namespace App\Application\Reporte\DTOs\Category;

use App\Shared\Abstracts\DTOs\DTO;
final class FullDistributionCategoryDTO extends DTO{

    /**
     * @param array<int, DistributionCategoryDTO> $data
     */
    public function __construct(
        public readonly array $data,
        public readonly int $total_movimientos
    )
    {
    }

}
