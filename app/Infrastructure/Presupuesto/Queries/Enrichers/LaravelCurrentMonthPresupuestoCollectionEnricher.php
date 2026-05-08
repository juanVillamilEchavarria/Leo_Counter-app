<?php

namespace App\Infrastructure\Presupuesto\Queries\Enrichers;

use App\Application\Presupuesto\Contracts\Queries\CurrentMonthPresupuestoCollectionEnricherContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Application\Presupuesto\DTOs\CurrentMonthPresupuestoForListDTO;
use Illuminate\Support\Collection;
use App\Models\Presupuesto\Presupuesto;

/**
 * Enricher concreto que transforma la coleccion de presupuestos del mes actual en una coleccion de DTOs
 * y anade el campo isDuplicate segun las categorias duplicadas.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\Presupuesto\Queries\Enrichers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelCurrentMonthPresupuestoCollectionEnricher implements CurrentMonthPresupuestoCollectionEnricherContract
{
    /**
     * {@inheritDoc}
     */
    public function enrich(CollectionContract $items, array $duplicatedCategoriaIds): CollectionContract
    {
        /**
         * @var Collection<Presupuesto> $items
         */
        $mapped = $items->map(function($item) use ($duplicatedCategoriaIds) {
            return new CurrentMonthPresupuestoForListDTO(
                (string) $item->id,
                (string) $item->categoria->nombre,
                (string) $item->user ? $item->user->name : null,
                (string) $item->periodo,
                (float) $item->monto,
                (string) ($item->descripcion ?? ''),
                in_array($item->categoria_id, $duplicatedCategoriaIds, true)
            );
        });

        return LaravelCollection::make($mapped->values());
    }
}
