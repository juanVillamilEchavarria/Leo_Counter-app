<?php

namespace App\Domains\Cuenta\Exceptions;

use App\Domains\Cuenta\Exceptions\CuentaException;

class CannotUpdateCuentaException extends CuentaException
{
    public function __construct($message = 'No se puede actualizar la cuenta')
    {
        parent::__construct($message);
    }
}
