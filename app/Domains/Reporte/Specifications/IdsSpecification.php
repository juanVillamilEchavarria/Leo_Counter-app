<?php

namespace App\Domains\Reporte\Specifications;
class IdsSpecification{
    public function isSatisfiedBy(iterable $ids){
        return !empty($ids);
    }
}