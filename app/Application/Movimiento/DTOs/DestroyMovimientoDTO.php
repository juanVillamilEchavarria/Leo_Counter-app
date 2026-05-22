<?php
namespace App\Application\Movimiento\DTOs;

use App\Shared\Abstracts\DTOs\DTO;

class DestroyMovimientoDTO extends DTO{
    public function __construct(
        public readonly string $password
    )
    {
    }
}