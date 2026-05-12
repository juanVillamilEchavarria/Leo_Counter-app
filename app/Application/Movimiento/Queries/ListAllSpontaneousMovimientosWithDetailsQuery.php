<?php

namespace App\Application\Movimiento\Queries;

use App\Application\Movimiento\Contracts\Queries\ListMovimientoQueryContract;
use App\Domains\Movimiento\Enums\MovimientoVariants;

/**
 * Query que representa la intención de obtener todos los movimientos espontaneos con sus relaciones.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllSpontaneousMovimientosWithDetailsQuery implements ListMovimientoQueryContract
{
}
