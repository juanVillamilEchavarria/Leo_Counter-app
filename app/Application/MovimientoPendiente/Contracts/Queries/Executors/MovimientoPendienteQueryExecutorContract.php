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

use App\Application\MovimientoPendiente\Contracts\Queries\ListMovimientoPendienteQueryContract;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato para executors de consultas de listado de MovimientoPendiente.
 * Define la operacion de lectura que entrega colecciones sin filtrar reglas de negocio.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
interface MovimientoPendienteQueryExecutorContract
{
    /**
     * Ejecuta una consulta de listado de movimientos pendientes.
     *
     * @param ListMovimientoPendienteQueryContract $query Query de listado.
     * @return CollectionContract Coleccion de resultados.
     */
    public function execute(ListMovimientoPendienteQueryContract $query): CollectionContract;
}
