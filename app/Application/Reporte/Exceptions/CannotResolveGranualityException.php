<?php

namespace App\Application\Reporte\Exceptions;

use App\Application\Reporte\Exceptions\ReporteException;
use Throwable;

class CannotResolveGranualityException extends ReporteException {
    public function __construct(string $message = "no se pudo resolver la granularidad del reporte", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}