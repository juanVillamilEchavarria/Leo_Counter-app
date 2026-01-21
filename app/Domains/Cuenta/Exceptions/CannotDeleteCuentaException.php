<?php

namespace App\Domains\Cuenta\Exceptions;

use App\Domains\Cuenta\Exceptions\CuentaException;

class CannotDeleteCuentaException extends CuentaException
{
    public function __construct($message = 'No se puede eliminar la cuenta')
    {
        parent::__construct($message);
    }
}
