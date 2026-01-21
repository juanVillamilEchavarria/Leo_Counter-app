<?php

namespace App\Domains\Propietario\Exceptions;

use App\Domains\Propietario\Exceptions\PropietarioException;
class CannotUpdatePropietarioException extends PropietarioException
{
    public function __construct($message = 'no se pudo actualizar el propietario')
    {
        parent::__construct($message);
    }
}
