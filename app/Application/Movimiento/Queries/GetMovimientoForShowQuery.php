<?php

namespace App\Application\Movimiento\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Query que representa la intención de obtener un movimiento para su visualización con detalles.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetMovimientoForShowQuery implements QueryContract
{
public function __construct(
    public string $id
)
{
}
}
