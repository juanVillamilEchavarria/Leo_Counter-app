<?php

namespace App\Domains\Categoria\Exceptions;

use App\Domains\Categoria\Exceptions\CategoriaException;

class CannotUpdateCategoriaException extends CategoriaException
{
    public function __construct($message = 'No se puede actualizar la categoria')
    {
        parent::__construct($message);
    }
}
