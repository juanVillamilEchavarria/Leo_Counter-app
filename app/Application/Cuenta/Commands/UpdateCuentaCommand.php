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

use App\Application\Cuenta\Commands\Abstracts\WriteCuentaCommand;

/**
 * Command to update an existing Cuenta
 */
final readonly class UpdateCuentaCommand extends WriteCuentaCommand
{
    public function __construct(
        public string $id,
        string $nombre,
        ?string $notas,
        float $saldo_inicial,
        string $propietario_id,
        int $tipo_cuenta_id,
    ) {
        parent::__construct($nombre ,$notas, $saldo_inicial, $propietario_id, $tipo_cuenta_id);
    }
}