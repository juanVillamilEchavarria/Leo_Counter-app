<?php

namespace App\Domains\Movimiento\Exceptions;

use App\Domains\Movimiento\Exceptions\MovimientoException;
use Throwable;

class CannotExecuteMovimientoTransactionException extends MovimientoException {
    public function __construct(string $message = "No se pudo realizar la transacción", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
