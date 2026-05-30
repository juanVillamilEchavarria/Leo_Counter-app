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
 * Command to destroy a Cuenta
 */
final readonly class DestroyCuentaCommand
{
    public function __construct(
        public string $id,
    ) {}
}