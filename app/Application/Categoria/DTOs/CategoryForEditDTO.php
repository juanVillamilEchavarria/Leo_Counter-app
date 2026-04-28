<?php

namespace App\Application\Categoria\DTOs;

use App\Shared\Abstracts\DTOs\DTO;

/**
 * DTO que representa los datos necesarios para editar una categoría específica.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final class CategoryForEditDTO extends DTO
{
    public function __construct(
        public int $id,
        public string $nombre,
        public int $tipo_movimiento_id,
        public ?string $descripcion,
    )
    {
    }
}