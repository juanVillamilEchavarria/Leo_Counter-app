<?php

namespace App\Application\Reporte\DTOs\Category;

use App\Shared\Abstracts\DTOs\DTO;
use App\Domains\Reporte\ValueObjects\Category\DistributionCategoryVO;
final class FullDistributionCategoryDTO extends DTO{

    /**
     * @param array<int, DistributionCategoryVO> $data - Distribucion de categorias agrupadas por periodo
     */
    public function __construct(
        public readonly array $data,
        public readonly int $total_movimientos
    )
    {
    }

}
