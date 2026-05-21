<?php

namespace App\Infrastructure\Configuracion\Queries\Enrichers;

use App\Application\Configuracion\Contracts\Queries\Enrichers\DeletedDomainRecordsEnricherContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use App\Application\Configuracion\DTOs\PresupuestoDeletedDTO;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;

/**
 * Enricher concreto que transforma presupuestos eliminados en DTOs y añade can_hard_delete.
 */
final readonly class LaravelPresupuestoDeletedEnricher implements DeletedDomainRecordsEnricherContract
{
    public function __construct(private DomainRecordCanBeDeletedCheckerContract $checker)
    {
    }

    public function enrich(CollectionContract $items): CollectionContract
    {
        $mapped = $items->map(function ($item) {
            $id = (string) $item->id;
            $can = $this->checker->canBeDeleted(new PresupuestoId($id));

            return new PresupuestoDeletedDTO(
                $id,
                (float) ($item->monto ?? 0),
                $item->descripcion ?? null,
                $item->periodo ? (string)$item->periodo : null,
                $item->deleted_at ? (string)$item->deleted_at : null,
                $can
            );
        });

        return LaravelCollection::make($mapped->values());
    }
}
