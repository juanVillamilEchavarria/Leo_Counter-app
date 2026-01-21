<?php

namespace App\Domains\Propietario\DTOs;

use App\Shared\DTOs\DTO;

class StoreAndUpdatePropietarioDTO extends DTO
{
    public function __construct(
        public string $nombre,
        public string $apellido,
        public string $telefono,
        public string $email,
    ){}

}