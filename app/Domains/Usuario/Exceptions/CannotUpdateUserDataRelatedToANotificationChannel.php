<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Usuario\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;

class CannotUpdateUserDataRelatedToANotificationChannel extends DomainException
{
    public function __construct(string $message = "No se puede actualizar los datos publicos del usuario relacionados con un canal de notificación.", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
