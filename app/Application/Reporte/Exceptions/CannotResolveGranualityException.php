<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Reporte\Exceptions;

use App\Shared\Application\Exceptions\ApplicationException;
use Throwable;

class CannotResolveGranualityException extends ApplicationException {
    public function __construct(string $message = "no se pudo resolver la granularidad del reporte", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
