<?php

namespace App\Domains\Reporte\Exception;

use App\Domains\Reporte\Exception\ReporteException;
use Throwable;

class CannotResolveGranualityException extends ReporteException {
    public function __construct(string $message = "no se pudo resolver la granularidad del reporte", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}