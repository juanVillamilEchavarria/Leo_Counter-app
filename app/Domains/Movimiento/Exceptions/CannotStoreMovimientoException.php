<?php 

namespace App\Domains\Movimiento\Exceptions;

use App\Domains\Movimiento\Exceptions\MovimientoException;
use Throwable;

class CannotStoreMovimientoException extends MovimientoException {
    public function __construct(string $message = "No se puede almacenar el movimiento", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
