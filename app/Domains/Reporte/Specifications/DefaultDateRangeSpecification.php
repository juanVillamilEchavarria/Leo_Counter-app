<?php

namespace App\Domains\Reporte\Specifications;

class DefaultDateRangeSpecification{
    public function isSatisfiedBy(array $data){
        return  empty($data['startDate']) && empty($data['endDate']); ;
    }
}