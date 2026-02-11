<?php

namespace App\Domains\Categoria\Exceptions;
use App\Domains\Categoria\Exceptions\CategoriaException;

class CannotStoreCategoriaException extends CategoriaException
{
    public function __construct($message='no se puede almacenar una categoria con el mismo nombre y tipo de movimiento')
    {
        parent::__construct($message);
    }
}
