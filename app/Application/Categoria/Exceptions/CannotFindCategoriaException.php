<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Categoria\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;
use Throwable;

class CannotFindCategoriaException extends DomainException{
    public function __construct(string $message = "Categoría no encontrada", int $code = 0, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
