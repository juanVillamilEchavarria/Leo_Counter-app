<?php

namespace App\Application\Categoria\DTOs;

/**
 * DTO que representa los datos necesarios para editar una categoría específica.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class CategoryForEditDTO
{
    public function __construct(
        public string $id,
        public string $nombre,
        public int $tipo_movimiento_id,
        public ?string $descripcion,
    )
    {
    }
}
