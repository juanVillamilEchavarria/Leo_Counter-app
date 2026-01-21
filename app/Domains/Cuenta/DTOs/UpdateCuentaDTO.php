<?php
namespace App\Domains\Cuenta\DTOs;

use App\Shared\DTOs\DTO;

class UpdateCuentaDTO extends DTO {
    public function __construct(
        public readonly string $propietario_id,
        public readonly string $tipo_cuenta_id,
        public readonly string $nombre,
        public readonly string $saldo_inicial,
        public readonly ?string $notas = null
    ){}

}