<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Cuenta\Exceptions;

use App\Domains\Cuenta\Exceptions\CuentaException;

class CannotUpdateCuentaException extends CuentaException
{
    public function __construct($message = 'No se puede actualizar la cuenta')
    {
        parent::__construct($message);
    }
}
