<?php

namespace App\Domains\MovimientoPendiente\Exceptions;

use Exception;

class CannotUpdateMovimientoPendienteException extends Exception
{
    public function __construct($message = "No se puede actualizar el movimiento pendiente", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
