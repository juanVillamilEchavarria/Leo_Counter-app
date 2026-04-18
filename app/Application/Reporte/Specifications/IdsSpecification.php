<?php

namespace App\Application\Reporte\Specifications;
class IdsSpecification{
    public function isSatisfiedBy(iterable | null $ids){
        return !empty($ids) || !is_null($ids);
    }
}