<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Propietario\Commands;

/**
 * Comando para eliminar un propietario.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class DestroyPropietarioCommand
{
    public function __construct(
        public string $id,
    ) {}
}
