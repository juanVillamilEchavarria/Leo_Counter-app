<?php

namespace App\Domains\Categoria\DTOs;

use App\Shared\Abstracts\DTOs\DTO;

class StoreAndUpdateCategoriaDTO extends DTO
{
    public function __construct(
        public string $nombre,
        public int $tipo_movimiento_id,
        public ?string $descripcion = null
    ){}
}