<?php

namespace App\Infrastructure\Movimiento\Queries\Executors\Eloquent;

use App\Application\Movimiento\Contracts\Queries\Executors\MovimientoQueryExecutorContract;
use App\Application\Movimiento\Queries\ListAllMovimientoWithDetailsQuery;
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
final readonly class EloquentListAllMovimientoWithDetailsExecutor implements MovimientoQueryExecutorContract
{
    public function execute(ListAllMovimientoWithDetailsQuery $query): CollectionContract
    {
        $q = Movimiento::with(['cuenta:id,nombre', 'categoria:id,nombre', 'tipo_movimiento:id,tipo_movimiento', 'movimientoPendiente']);

        if(isset($query->variant) && $query->variant === MovimientoVariants::ESPONTANEO){
            $q = $q->where('movimiento_pendiente_id', null)->where('fecha', Carbon::now()->format('Y-m-d'));
        }

        $items = $q->get();
        return LaravelCollection::make($items);
    }
}
