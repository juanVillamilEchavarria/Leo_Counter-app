<?php

namespace App\Infrastructure\Configuracion\Queries\Enrichers;

use App\Application\Configuracion\Contracts\Queries\Enrichers\DeletedDomainRecordsEnricherContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use App\Application\Configuracion\DTOs\CategoriaDeletedDTO;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;

/**
 * Enricher concreto que transforma categorias eliminadas en DTOs y añade can_hard_delete.
 */
final readonly class LaravelCategoriaDeletedEnricher implements DeletedDomainRecordsEnricherContract
{
    public function __construct(private DomainRecordCanBeDeletedCheckerContract $checker)
    {
    }

    public function enrich(CollectionContract $items): CollectionContract
    {
        $mapped = $items->map(function ($item) {
            $id = (string) $item->id;
            $can = $this->checker->canBeDeleted(new CategoriaId($id));

            return new CategoriaDeletedDTO(
                $id,
                $item->nombre ?? null,
                $item->descripcion ?? null,
                (bool) ($item->es_fijo ?? false),
                $item->deleted_at ? (string)$item->deleted_at : null,
                $can
            );
        });

        return LaravelCollection::make($mapped->values());
    }
}
