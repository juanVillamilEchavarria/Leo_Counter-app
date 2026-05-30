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

use App\Shared\Domain\Contracts\CollectionContract;

final readonly class CategoriaFormOptionsDTO
{
    public function __construct(
        public CollectionContract $tipos
    ){}
}
