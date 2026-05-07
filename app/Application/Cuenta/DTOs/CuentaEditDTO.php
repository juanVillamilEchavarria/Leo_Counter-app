<?php
namespace App\Application\Cuenta\DTOs;

use App\Shared\Abstracts\DTOs\DTO;

final class CuentaEditDTO extends DTO{
    public function __construct(
         public string $id,
        public string $nombre,
        public ?string $notas,
        public float $saldo_inicial,
        public string $propietario_id,
        public int $tipo_cuenta_id,
        public bool $can_update_saldo,
    )
     {
    }
}