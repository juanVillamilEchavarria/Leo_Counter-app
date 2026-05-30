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

use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato para el ejecutor de la consulta de todos los archivos de un movimiento
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface GetAllArchivoMovimientosForAMovimientoQueryExecutorContract
{
    /**
     *Obtiene todos los archivos de un movimiento
     * @param MovimientoId $movimientoId
     * @return CollectionContract
     */
    public function execute(MovimientoId $movimientoId):CollectionContract;

}
