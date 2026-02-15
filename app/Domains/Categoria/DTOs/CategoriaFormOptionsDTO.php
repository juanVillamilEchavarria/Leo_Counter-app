<?php

namespace App\Domains\Categoria\DTOs;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Database\Eloquent\Collection;

class CategoriaFormOptionsDTO extends DTO
{
    public function __construct(
        public Collection $tipos
    ){}
}