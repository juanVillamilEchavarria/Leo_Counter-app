<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Cuenta\Commands;

/**
 * Command to toggle a boolean attribute of a Cuenta
 */
final readonly class ToggleCuentaCommand
{
    public function __construct(
        public string $id,
        public string $attribute,
    ) {}
}