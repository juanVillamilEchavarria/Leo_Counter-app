<?php

namespace App\Infrastructure\Presupuesto\Queries\Executors\Eloquent;

use App\Application\Presupuesto\Contracts\Queries\Executors\PresupuestoQueryExecutorContract;
use App\Application\Presupuesto\Contracts\Queries\ListPresupuestosQueryContract;
use Illuminate\Database\Eloquent\Collection;
use App\Shared\Enums\ComparativeOperators;
use Carbon\Carbon;
use App\Models\Presupuesto\Presupuesto;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use DateTimeImmutable;
use Override;
/**
 * Ejecutor de la consulta para obtener todos los presupuestos del mes actual con detalles completos utilizando Eloquent ORM.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Presupuesto\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EloquentListAllCurrentMonthPresupuestosWithDetailsQueryExecutor implements PresupuestoQueryExecutorContract
{
   #[Override]
   public function execute(ListPresupuestosQueryContract $query): CollectionContract
   {
     $items = Presupuesto::with(['categoria:id,nombre', 'user:id,name'])
            ->whereDate('periodo', Carbon::now()->firstOfMonth())
            ->get();
    return LaravelCollection::make($items);
   }
}
