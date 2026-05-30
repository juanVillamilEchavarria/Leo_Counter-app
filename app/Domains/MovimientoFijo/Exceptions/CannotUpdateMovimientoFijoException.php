<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\MovimientoFijo\Exceptions;

use Exception;
use App\Domains\MovimientoFijo\Exceptions\MovimientoFijoException;

class CannotUpdateMovimientoFijoException extends MovimientoFijoException
{
    public function __construct($message = 'no se pudo actualizar el movimiento fijo')
    {
        parent::__construct($message);
    }
}
