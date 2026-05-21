<?php

namespace App\Infrastructure\Presupuesto\Queries\Executors\Eloquent;

use App\Application\Presupuesto\Contracts\Queries\Executors\PresupuestoQueryExecutorContract;
use App\Application\Presupuesto\Contracts\Queries\ListPresupuestosQueryContract;
use App\Models\Presupuesto\Presupuesto;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Query executor Eloquent para listar presupuestos eliminados.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Presupuesto\Queries\Executors\Eloquent
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListAllPresupuestosDeletedQueryExecutor implements PresupuestoQueryExecutorContract
{
    public function execute(ListPresupuestosQueryContract $query): CollectionContract
    {
        return LaravelCollection::make(
            Presupuesto::onlyTrashed()
                ->with(['categoria:id,nombre', 'user:id,name'])
                ->get()
        );
    }
}
