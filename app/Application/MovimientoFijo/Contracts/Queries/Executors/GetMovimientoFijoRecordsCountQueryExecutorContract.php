<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoFijo\Contracts\Queries\Executors;

/**
 * Contrato para obtener el total de registros de MovimientoFijo.
 * Aisla el conteo de registros en un query executor especifico de infraestructura.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
interface GetMovimientoFijoRecordsCountQueryExecutorContract
{
    /**
     * Ejecuta el conteo total de movimientos fijos.
     *
     * @return int Total de registros.
     */
    public function execute(): int;
}
