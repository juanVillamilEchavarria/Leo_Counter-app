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
use App\Shared\Domain\Contracts\CollectionContract;
use App\Domains\ArchivoMovimiento\ValueObjects\ArchivoMovimientoId;

/**
 * Obtiene todos los archivos movimientos relacionados a un movimiento.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *  @since 1.0.0
 *  @version 1.0.
 */
interface GetAllArchivoMovimientosIdsForAMovimientoQueryExecutorContract
{
    /**
     * @param MovimientoId $id
     * @return CollectionContract<ArchivoMovimientoId>
     */
    public function execute(MovimientoId $id): CollectionContract;

}
