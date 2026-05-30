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

use App\Application\Movimiento\Contracts\Queries\ListMovimientoQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato que deben implementar todos los ejecutores de consultas de movimientos que obtengan un listado de movimientos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface MovimientoQueryExecutorContract
{
    public function execute(ListMovimientoQueryContract $query): CollectionContract;
}
