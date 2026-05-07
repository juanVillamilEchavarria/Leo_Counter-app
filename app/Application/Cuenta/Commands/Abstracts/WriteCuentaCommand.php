<?php

namespace App\Application\Cuenta\Commands\Abstracts;

/**
 * Abstract command for write operations on Cuenta
 */
abstract readonly class WriteCuentaCommand
{
    public function __construct(
        public string $nombre,
        public ?string $notas,
        public float $saldo_inicial,
        public string $propietario_id,
        public int $tipo_cuenta_id,
    ) {}
}
