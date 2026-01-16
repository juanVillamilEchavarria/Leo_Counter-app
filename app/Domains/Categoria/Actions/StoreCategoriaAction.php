<?php

namespace App\Domains\Categoria\Actions;

use App\Models\Categoria\Categoria;
use App\Domains\Categoria\DTOs\StoreAndUpdateCategoriaDTO;

class StoreCategoriaAction
{
    public function store(StoreAndUpdateCategoriaDTO $dto): Categoria
    {
        return Categoria::create($dto->toArray());
    }
}