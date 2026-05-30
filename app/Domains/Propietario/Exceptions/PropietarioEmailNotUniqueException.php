<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Propietario\Exceptions;

use App\Domains\Propietario\Exceptions\PropietarioException;

final class PropietarioEmailNotUniqueException extends PropietarioException
{
    public function __construct(string $message = 'El correo electrónico ya está en uso por otro propietario.')
    {
        parent::__construct($message);
    }
}
