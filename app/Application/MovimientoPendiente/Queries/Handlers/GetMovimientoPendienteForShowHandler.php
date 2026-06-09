<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\Queries\Handlers;

use App\Application\MovimientoPendiente\Contracts\Queries\Executors\MovimientoPendienteForShowQueryExecutorContract;
use App\Application\MovimientoPendiente\DTOs\MovimientoPendienteShowDTO;
use App\Application\MovimientoPendiente\Queries\GetMovimientoPendienteForShowQuery;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;

/**
 * Handler encargado de obtener un movimiento pendiente con sus detalles para visualizacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetMovimientoPendienteForShowHandler
{
    public function __construct(
        private MovimientoPendienteForShowQueryExecutorContract $executor,
    ) {
    }

    public function __invoke(GetMovimientoPendienteForShowQuery $query): MovimientoPendienteShowDTO
    {
        return $this->executor->execute(new MovimientoPendienteId($query->id));
    }
}
