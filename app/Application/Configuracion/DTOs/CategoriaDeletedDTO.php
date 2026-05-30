<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Configuracion\DTOs;

/**
 * DTO que representa una categoria eliminada con metadata para presentacion.
 *
 * @package App\Application\Configuracion\DTOs
 */
final readonly class CategoriaDeletedDTO
{
    /**
     * @param string $id
     * @param string|null $nombre
     * @param string|null $descripcion
     * @param bool $es_fijo
     * @param string|null $deleted_at
     * @param bool $can_hard_delete
     */
    public function __construct(
        public string $id,
        public ?string $nombre,
        public ?string $descripcion,
        public bool $es_fijo,
        public ?string $deleted_at,
        public bool $can_hard_delete
    ){
    }
}
