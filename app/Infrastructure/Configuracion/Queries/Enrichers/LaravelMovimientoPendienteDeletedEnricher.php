<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Configuracion\Queries\Enrichers;

use App\Application\Configuracion\Contracts\Queries\Enrichers\DeletedDomainRecordsEnricherContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use App\Application\Configuracion\DTOs\MovimientoPendienteDeletedDTO;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;

/**
 * Enricher concreto que transforma movimientos pendientes eliminados en DTOs y añade can_hard_delete.
 */
final readonly class LaravelMovimientoPendienteDeletedEnricher implements DeletedDomainRecordsEnricherContract
{
    public function __construct(private DomainRecordCanBeDeletedCheckerContract $checker)
    {
    }

    public function enrich(CollectionContract $items): CollectionContract
    {
        $mapped = $items->map(function ($item) {
            $id = (string) $item->id;
            $can = $this->checker->canBeDeleted(new MovimientoPendienteId($id));

            return new MovimientoPendienteDeletedDTO(
                $id,
                $item->nombre ?? null,
                (float) ($item->monto ?? 0),
                $item->fecha_programada ? (string)$item->fecha_programada : null,
                $item->estado ?? null,
                $item->deleted_at ? (string)$item->deleted_at : null,
                $can
            );
        });

        return LaravelCollection::make($mapped->values());
    }
}
