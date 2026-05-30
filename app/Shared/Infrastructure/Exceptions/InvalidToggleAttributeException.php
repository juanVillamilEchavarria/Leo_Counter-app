<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Infrastructure\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;
use Throwable;

class InvalidToggleAttributeException extends DomainException
{
    public function __construct(string $message = "Atributo no válido para alternar", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
