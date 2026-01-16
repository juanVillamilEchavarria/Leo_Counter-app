<?php

namespace App\Domains\Categoria\Actions;

use App\Models\Categoria\Categoria;


class DestroyCategoriaAction
{
    public function destroy(Categoria $categoria): bool
    {
        if($categoria->is_system) {
            throw new \Exception("No se puede eliminar una categoria del sistema.");
        }
        return $categoria->delete();
    }
}