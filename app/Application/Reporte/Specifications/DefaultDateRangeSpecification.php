<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Reporte\Specifications;

class DefaultDateRangeSpecification{
    public function isSatisfiedBy(?string $startDate , ?string $endDate): bool{
        return  is_null($startDate) && is_null($endDate);
    }
}