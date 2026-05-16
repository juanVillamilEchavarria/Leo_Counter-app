<?php

namespace App\Infrastructure\ArchivoMovimiento\Queries\Executors\Eloquent;

use App\Application\Movimiento\Contracts\Queries\Executors\GetAllArchivoMovimientosForAMovimientoQueryExecutorContract;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Contrato para el ejecutor de la consulta de todos los archivos de un movimiento
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */

final readonly class EloquentGetAllArchivoMovimientosForAMovimientoQueryExecutorContract implements GetAllArchivoMovimientosForAMovimientoQueryExecutorContract
{

    /**
     * @inheritDoc
     */
    public function execute(MovimientoId $movimientoId): CollectionContract
    {
       $records= ArchivoMovimiento::where('movimiento_id', $movimientoId->getValue())->get();
       return LaravelCollection::make($records);
    }
}
