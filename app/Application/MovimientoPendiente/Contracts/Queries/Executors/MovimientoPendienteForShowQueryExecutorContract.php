<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\Contracts\Queries\Executors;

use App\Application\MovimientoPendiente\DTOs\MovimientoPendienteShowDTO;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;

/**
 * Contrato que define el comportamiento del executor de la intencion de obtener un movimiento pendiente para su visualizacion con detalles.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 * @see MovimientoPendienteShowDTO
 */
interface MovimientoPendienteForShowQueryExecutorContract
{
    /**
     * Obtiene el movimiento pendiente con sus detalles.
     *
     * @param MovimientoPendienteId $id
     * @return MovimientoPendienteShowDTO
     */
    public function execute(MovimientoPendienteId $id): MovimientoPendienteShowDTO;
}
