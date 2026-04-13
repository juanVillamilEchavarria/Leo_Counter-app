<?php

namespace App\Application\Reporte\Specifications;

class DefaultDateRangeSpecification{
    public function isSatisfiedBy(?string $startDate , ?string $endDate): bool{
        return  is_null($startDate) && is_null($endDate);
    }
}