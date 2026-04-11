<?php

namespace App\Application\Reporte\DTOs\Category;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Support\Collection;
class FullDistributionCategoryDTO extends DTO{

    public function __construct(
        public Collection $data,
        public int $total_movimientos
    )
    {
    }

}