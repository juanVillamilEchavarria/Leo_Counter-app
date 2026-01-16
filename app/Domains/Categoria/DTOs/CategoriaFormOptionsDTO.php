<?php

namespace App\Domains\Categoria\DTOs;
use Illuminate\Database\Eloquent\Collection;

class CategoriaFormOptionsDTO
{
    public function __construct(
        public Collection $tipos
    ){}
}