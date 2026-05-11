<?php

namespace App\Application\Movimiento\Queries;

use App\Application\Movimiento\Contracts\Queries\ListMovimientoQueryContract;
use App\Domains\Movimiento\Enums\MovimientoVariants;

/**
 * Query que representa la intención de obtener todos los movimientos con sus relaciones.
 * Opcionalmente acepta un variant para filtrar (por ejemplo ESPONTANEO).
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllMovimientoWithDetailsQuery implements ListMovimientoQueryContract
{
    public function __construct(
        public readonly MovimientoVariants $variant = MovimientoVariants::TOTAL
    ){}
}
