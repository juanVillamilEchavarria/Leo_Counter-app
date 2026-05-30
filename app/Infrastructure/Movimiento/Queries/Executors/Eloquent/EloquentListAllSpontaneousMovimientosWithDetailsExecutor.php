<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Movimiento\Queries\Executors\Eloquent;

use App\Application\Movimiento\Contracts\Queries\Executors\MovimientoQueryExecutorContract;
use App\Application\Movimiento\Contracts\Queries\ListMovimientoQueryContract;
use App\Application\Movimiento\Queries\ListAllSpontaneousMovimientosWithDetailsQuery;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Models\Movimiento\Movimiento;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use Carbon\Carbon;
use App\Domains\Movimiento\Enums\MovimientoVariants;


/**
 * Ejecutor Eloquent que obtiene todos los movimientos con relaciones.
 * Soporta filtrado por variante (por ejemplo ESPONTANEO).
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListAllSpontaneousMovimientosWithDetailsExecutor implements MovimientoQueryExecutorContract
{
    public function execute(ListMovimientoQueryContract $query): CollectionContract
    {
        $items = Movimiento::with(['cuenta:id,nombre', 'categoria:id,nombre', 'tipo_movimiento:id,tipo_movimiento', 'movimientoPendiente'])
        ->where('movimiento_pendiente_id', null)->whereDate('fecha','=', Carbon::now()->format('Y-m-d'))
        ->get();
        return LaravelCollection::make($items);
    }
}
