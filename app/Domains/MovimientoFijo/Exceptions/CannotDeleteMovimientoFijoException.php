<?php

namespace App\Domains\MovimientoFijo\Exceptions;

use App\Domains\MovimientoFijo\Exceptions\MovimientoFijoException;

class CannotDeleteMovimientoFijoException extends MovimientoFijoException
{
    public function __construct(string $message = 'No se puede eliminar un movimiento fijo con movimientos asociados')
    {
        parent::__construct($message);
    }
}
