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

use App\Domains\MovimientoFijo\Exceptions\MovimientoFijoException;

class CannotDeleteMovimientoFijoException extends MovimientoFijoException
{
    public function __construct(string $message = 'No se puede eliminar un movimiento fijo con movimientos asociados')
    {
        parent::__construct($message);
    }
}
