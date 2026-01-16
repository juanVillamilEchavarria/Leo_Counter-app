<?php

namespace App\Domains\Categoria\DTOs;

class StoreAndUpdateCategoriaDTO
{
    public function __construct(
        public string $nombre,
        public int $tipo_movimiento_id,
        public ?string $descripcion
    ){}

    public function toArray(): array
    {
        return [
            'nombre' => $this->nombre,
            'tipo_movimiento_id' => $this->tipo_movimiento_id,
            'descripcion' => $this->descripcion,
        ];
    }
}