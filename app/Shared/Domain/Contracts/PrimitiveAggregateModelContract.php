<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Shared\Domain\Contracts;

/**
 * Contrato que deben implementar todos los agregados que deban devolver un array con sus valores primitivos
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
interface PrimitiveAggregateModelContract extends AggregateModelContract
{

    /**
     * Devuelve un array con las propiedades primitivas del agregado
     * @return array
     */
    public function toPrimitive(): array;

}
