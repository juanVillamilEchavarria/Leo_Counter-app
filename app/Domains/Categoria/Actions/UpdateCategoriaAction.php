<?php

namespace App\Domains\Categoria\Actions;

use App\Models\Categoria\Categoria;
use App\Domains\Categoria\DTOs\StoreAndUpdateCategoriaDTO;
use App\Domains\Categoria\Exceptions\CannotUpdateCategoriaException;
use DomainException;

class UpdateCategoriaAction
{
    public function update(Categoria $categoria, StoreAndUpdateCategoriaDTO $dto): bool
    {
        if(!$categoria){
            throw new CannotUpdateCategoriaException;
        }
        return $categoria->update($dto->toArray());
        
    }

    public function toggleEsFijo(Categoria $categoria): bool
    {
        if(!$categoria){
            throw new CannotUpdateCategoriaException;
        }
        return $categoria->update(['es_fijo' => !$categoria->es_fijo]);
    }
}