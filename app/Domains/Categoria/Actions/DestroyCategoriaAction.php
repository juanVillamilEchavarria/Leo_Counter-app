<?php

namespace App\Domains\Categoria\Actions;

use App\Models\Categoria\Categoria;
use App\Domains\Categoria\Exceptions\CannotDeleteCategoriaException;


class DestroyCategoriaAction
{
    public function destroy(Categoria $categoria): bool
    {
        if($categoria->is_system) {
            throw new CannotDeleteCategoriaException;
        }
        return $categoria->delete();
    }
}