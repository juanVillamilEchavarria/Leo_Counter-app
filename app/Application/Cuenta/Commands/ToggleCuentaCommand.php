<?php

namespace App\Application\Cuenta\Commands;

/**
 * Command to toggle a boolean attribute of a Cuenta
 */
final readonly class ToggleCuentaCommand
{
    public function __construct(
        public int $id,
        public string $attribute,
    ) {}
}