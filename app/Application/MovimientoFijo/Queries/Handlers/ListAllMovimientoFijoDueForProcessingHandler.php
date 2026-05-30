<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoFijo\Queries\Handlers;

use App\Application\MovimientoFijo\Queries\ListAllMovimientoFijoDueForProcessingQuery;
use App\Application\MovimientoFijo\Contracts\Queries\Executors\MovimientoFijoQueryExecutorContract;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Manejador de la query para obtener los movimientos fijos que se deben procesar por la automatizacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListAllMovimientoFijoDueForProcessingHandler
{
    public function __construct(
        private readonly MovimientoFijoQueryExecutorContract $movimientoFijoQueryExecutorContract
    )
    {
    }
    public function __invoke(ListAllMovimientoFijoDueForProcessingQuery $query) : CollectionContract
    {
        return $this->movimientoFijoQueryExecutorContract->execute($query);
    }

}
