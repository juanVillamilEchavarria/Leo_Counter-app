<?php

namespace App\Domains\Propietario\DTOs;

class StoreAndUpdatePropietarioDTO
{
    public function __construct(
        public string $nombre,
        public string $apellido,
        public string $telefono,
        public string $email,
    ){}

    public function toArray(): array
    {
        return [
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'telefono' => $this->telefono,
            'email' => $this->email,
        ];
    }
}