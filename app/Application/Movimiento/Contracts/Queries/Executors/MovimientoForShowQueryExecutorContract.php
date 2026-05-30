<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\Contracts\Queries\Executors;

use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Application\Movimiento\DTOs\MovimientoShowDTO;

/**
 * Contrato que define el comportamiento del executor de la intención de obtener un movimiento para su visualización con detalles.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.
 * @see MovimientoShowDTO
 */
interface MovimientoForShowQueryExecutorContract
{
    /**
     * Obtiene el movimiento con sus detalles
     * @param MovimientoId $id
     * @return MovimientoShowDTO
     */
    public function execute(MovimientoId $id) : MovimientoShowDTO;

}
