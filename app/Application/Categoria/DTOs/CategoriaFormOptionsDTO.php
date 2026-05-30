<?php

namespace App\Application\Categoria\DTOs;

use App\Shared\Domain\Contracts\CollectionContract;

final readonly class CategoriaFormOptionsDTO
{
    public function __construct(
        public CollectionContract $tipos
    ){}
}
