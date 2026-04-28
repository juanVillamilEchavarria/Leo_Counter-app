<?php 

namespace App\Domains\Cuenta\Exceptions;

use App\Shared\Abstracts\Exceptions\DomainException;
use Throwable;

class CannotFindCuentaException extends DomainException {
    public function __construct(string $message = "No se puede encontrar la cuenta", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
