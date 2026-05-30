<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\ArchivoMovimiento\Queries\Executors\Eloquent;

use App\Application\Movimiento\Contracts\Queries\Executors\GetAllArchivoMovimientosIdsForAMovimientoQueryExecutorContract;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use App\Domains\ArchivoMovimiento\ValueObjects\ArchivoMovimientoId;

final readonly class EloquentGetAllArchivoMovimientosIdsForAMovimientoQueryExecutorContract implements GetAllArchivoMovimientosIdsForAMovimientoQueryExecutorContract
{

    public function execute(MovimientoId $id): CollectionContract
    {
        $ids = ArchivoMovimiento::where('movimiento_id', $id)
            ->select('id', 'movimiento_id')
            ->get();

        $ids = $ids->map(function ($id) {
            return new ArchivoMovimientoId($id->id);
        });
        return LaravelCollection::make($ids);
    }
}
