<?php

namespace App\Application\Categoria\DTOs;

use App\Shared\Abstracts\DTOs\DTO;
use App\Shared\Domain\Contracts\CollectionContract;
use Illuminate\Database\Eloquent\Collection;

class CategoriaFormOptionsDTO extends DTO
{
    public function __construct(
        public CollectionContract $tipos
    ){}
}