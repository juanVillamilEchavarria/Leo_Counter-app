<?php

namespace App\Domains\MovimientoFijo\Exceptions;

use Exception;
use App\Domains\MovimientoFijo\Exceptions\MovimientoFijoException;

class CannotUpdateMovimientoFijoException extends MovimientoFijoException
{
    public function __construct($message = 'no se pudo actualizar el movimiento fijo')
    {
        parent::__construct($message);
    }
}
