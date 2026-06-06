<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Presupuesto\Exceptions;

use App\Shared\Application\Exceptions\ApplicationException;
use Override;
use Throwable;

class CannotFindPresupuestoException extends ApplicationException
{
    public function __construct(string $message = "no se pudo encontrar el presupuesto", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
