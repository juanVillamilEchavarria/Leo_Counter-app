<?php
namespace App\Domains\Reporte\Collections;

use App\Domains\Reporte\Builders\DistributionCategoryBuilder;
use App\Domains\Reporte\DTOs\DistributionCategoryDTO;
use Illuminate\Support\Collection;

class DistributionCategoryCollection extends Collection{

    public static function fromQueryResults(Collection $queryResults) {
        return new self(DistributionCategoryBuilder::fromQueryResults($queryResults));
    }
    public function totalMovimientos(){
        return $this->sum(fn(DistributionCategoryDTO $mes) => $mes->cantidad);
    }
}