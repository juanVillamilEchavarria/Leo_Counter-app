<?php

namespace App\Application\Reporte\Specifications;
class IdsSpecification{
    public function isSatisfiedBy(iterable $ids){
        return !empty($ids);
    }
}