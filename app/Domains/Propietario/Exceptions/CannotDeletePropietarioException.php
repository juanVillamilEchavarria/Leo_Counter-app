<?php

namespace App\Domains\Propietario\Exceptions;

use App\Domains\Propietario\Exceptions\PropietarioException;

class CannotDeletePropietarioException extends PropietarioException
{
    public function __construct($message = 'No se pudo eliminar el propietario')
    {
        parent::__construct($message);
    }
}
