<?php

namespace App\Domains\Usuario\Exceptions;

use App\Shared\Domain\Exceptions\DomainException;

class CannotUpdateUserDataRelatedToANotificationChannel extends DomainException
{
    public function __construct(string $message = "No se puede actualizar los datos publicos del usuario relacionados con un canal de notificación.", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
