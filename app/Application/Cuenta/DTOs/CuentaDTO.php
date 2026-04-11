<?php

namespace App\Application\Cuenta\DTOs;

use App\Shared\Abstracts\DTOs\DTO;

abstract class CuentaDTO extends DTO{

    public readonly float $saldo_actual;
    public function __construct(
        public readonly string $propietario_id,
        public readonly string $tipo_cuenta_id,
        public readonly string $nombre,
        public readonly float $saldo_inicial,
        public readonly ?string $notas = null,
    ){
        $this->saldo_actual = $this->saldo_inicial;
    }

}