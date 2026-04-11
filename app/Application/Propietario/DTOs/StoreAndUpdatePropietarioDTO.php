<?php

namespace App\Application\Propietario\DTOs;

use App\Shared\Abstracts\DTOs\DTO;

class StoreAndUpdatePropietarioDTO extends DTO
{
    public function __construct(
        public string $nombre,
        public string $apellido,
        public string $telefono,
        public string $email,
    ){}

}