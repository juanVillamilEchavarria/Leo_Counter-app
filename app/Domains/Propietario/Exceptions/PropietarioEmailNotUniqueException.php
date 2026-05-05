<?php

namespace App\Domains\Propietario\Exceptions;

use App\Domains\Propietario\Exceptions\PropietarioException;

final class PropietarioEmailNotUniqueException extends PropietarioException
{
    public function __construct(string $message = 'El correo electrónico ya está en uso por otro propietario.')
    {
        parent::__construct($message);
    }
}
