<?php

namespace App\Application\MovimientoFijo\Contracts\Queries\Executors;

use App\Application\MovimientoFijo\Contracts\Queries\ListMovimientoFijoQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato para executors de consultas de listado de MovimientoFijo.
 * Define la operacion de lectura que entrega colecciones sin filtrar reglas de negocio.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
interface MovimientoFijoQueryExecutorContract
{
    /**
     * Ejecuta una consulta de listado de movimiento fijo.
     *
     * @param ListMovimientoFijoQueryContract $query Query de listado.
     * @return CollectionContract Coleccion de resultados.
     */
    public function execute(ListMovimientoFijoQueryContract $query): CollectionContract;
}
