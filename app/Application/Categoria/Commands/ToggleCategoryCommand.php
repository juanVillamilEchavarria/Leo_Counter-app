<?php

namespace App\Application\Categoria\Commands;
/**
 * Este comando representa la intención de alternar el valor de un atributo booleano en una categoría específica.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ToggleCategoryCommand
{
    /**
     * @param int $id El ID de la categoría a la que se le va a alternar el valor del atributo
     * @param string $attribute El nombre del atributo booleano que se va a alternar
     */
    public function __construct(
        public int $id,
        public string $attribute
    ){}
}