<?php

namespace App\Application\Presupuesto\Exceptions;

use Override;
use RuntimeException;
use Throwable;

class CannotFindPresupuestoException extends RuntimeException
{
    public function __construct(string $message = "no se pudo encontrar el presupuesto", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}