<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Categoria\DTOs;

/**
 * DTO que representa los datos necesarios para editar una categoría específica.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class CategoriaForEditDTO
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
