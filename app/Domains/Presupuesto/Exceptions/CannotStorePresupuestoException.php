<?php

namespace App\Domains\Presupuesto\Exceptions;

use Exception;
use App\Domains\Presupuesto\Exceptions\PresupuestoException;
use Throwable;

class CannotStorePresupuestoException extends PresupuestoException
{
    public function __construct(string $message = "No se puede almacenar el presupuesto", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
