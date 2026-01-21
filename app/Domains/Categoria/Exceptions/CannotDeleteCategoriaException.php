<?php

namespace App\Domains\Categoria\Exceptions;
use App\Domains\Categoria\Exceptions\CategoriaException;

class CannotDeleteCategoriaException extends CategoriaException
{
    public function __construct($message='no se puede eliminar una categoria propia del sistema')
    {
        parent::__construct($message);
    }
}
