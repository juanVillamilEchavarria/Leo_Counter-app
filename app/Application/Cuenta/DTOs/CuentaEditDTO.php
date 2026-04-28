<?php
namespace App\Application\Cuenta\DTOs;

use App\Shared\Abstracts\DTOs\DTO;

final class CuentaEditDTO extends DTO{
    public function __construct(
         public int $id,
        public string $nombre,
        public ?string $descripcion,
        public float $saldo_inicial,
        public int $propietario_id,
        public int $tipo_cuenta_id,
        public bool $can_update_saldo,
    )
     {
    }
}