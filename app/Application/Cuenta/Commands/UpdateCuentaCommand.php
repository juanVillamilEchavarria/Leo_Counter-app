<?php

namespace App\Application\Cuenta\Commands;

use App\Application\Cuenta\Commands\Abstracts\WriteCuentaCommand;

/**
 * Command to update an existing Cuenta
 */
final readonly class UpdateCuentaCommand extends WriteCuentaCommand
{
    public function __construct(
        public int $id,
        string $nombre,
        ?string $notas,
        float $saldo_inicial,
        int $propietario_id,
        int $tipo_cuenta_id,
    ) {
        parent::__construct($nombre ,$notas, $saldo_inicial, $propietario_id, $tipo_cuenta_id);
    }
}