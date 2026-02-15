<?php

namespace App\Domains\ArchivoMovimiento\Exceptions;

use App\Domains\ArchivoMovimiento\Exceptions\ArchivoMovimientoException;
use Throwable;

class CannotDeleteArchivoMovimientoException extends ArchivoMovimientoException{
    public function __construct(string $message = "No se puede eliminar el archivo de movimiento", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}