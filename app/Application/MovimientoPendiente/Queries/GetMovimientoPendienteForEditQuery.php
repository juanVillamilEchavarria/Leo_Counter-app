<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Query que representa la intencion de obtener un movimiento pendiente para edicion.
 * Transporta la identidad como string para que el handler la convierta al value object correspondiente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetMovimientoPendienteForEditQuery implements QueryContract
{
    public function __construct(
        public string $id,
    ) {
    }
}
