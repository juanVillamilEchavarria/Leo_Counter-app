<?php

namespace App\Application\MovimientoFijo\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Query que representa la intencion de obtener opciones para formularios de MovimientoFijo.
 * El handler compone categorias, cuentas, tipos de movimiento y frecuencias desde executors compartidos.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListMovimientoFijoFormOptionsQuery implements QueryContract
{
}
