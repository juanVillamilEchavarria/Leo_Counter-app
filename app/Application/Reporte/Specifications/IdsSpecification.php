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
class IdsSpecification{
    public function isSatisfiedBy(iterable | null $ids){
        return !empty($ids) || !is_null($ids);
    }
}