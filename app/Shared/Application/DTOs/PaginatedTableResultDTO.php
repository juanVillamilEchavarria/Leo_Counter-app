<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Application\DTOs;
use App\Shared\Domain\Contracts\CollectionContract;
/**
 * DTO que se encarga de representar el resultado de una paginacion de una tabla.
 * devuelve los items y la meta data de la paginacion.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Application\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class PaginatedTableResultDTO{

    public function __construct(
        /** @var CollectionContract Items de la paginacion */
        public readonly CollectionContract $items,
        /** @var int Total de registros sin paginar */
        public int $total,
        /** @var int Registros por página */
        public int $perPage,
        /** @var int Página actual */
        public int $currentPage,
        /** @var int Última página disponible */
        public int $lastPage,
    )
    {
    }

}