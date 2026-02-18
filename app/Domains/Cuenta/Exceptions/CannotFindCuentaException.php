<?php 

namespace App\Domains\Cuenta\Exceptions;

use App\Domains\Cuenta\Exceptions\CuentaException;
use Throwable;

class CannotFindCuentaException extends CuentaException {
    public function __construct(string $message = "No se puede encontrar la cuenta", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
