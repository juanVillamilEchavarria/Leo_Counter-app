<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Categoria\Commands;
/**
 * Este comando representa la intención de alternar el valor de un atributo booleano en una categoría específica.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ToggleCategoriaCommand
{
    /**
     * @param string $id El ID de la categoría a la que se le va a alternar el valor del atributo
     * @param string $attribute El nombre del atributo booleano que se va a alternar
     */
    public function __construct(
        public string $id,
        public string $attribute
    ){}
}
