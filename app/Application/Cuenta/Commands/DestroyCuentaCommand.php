<?php

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