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
use App\Application\Configuracion\DTOs\CuentaDeletedDTO;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;

/**
 * Enricher concreto que transforma cuentas eliminadas en DTOs y añade can_hard_delete.
 */
final readonly class LaravelCuentaDeletedEnricher implements DeletedDomainRecordsEnricherContract
{
    public function __construct(private DomainRecordCanBeDeletedCheckerContract $checker)
    {
    }

    public function enrich(CollectionContract $items): CollectionContract
    {
        $mapped = $items->map(function ($item) {
            $id = (string) $item->id;
            $can = $this->checker->canBeDeleted(new CuentaId($id));

            return new CuentaDeletedDTO(
                $id,
                $item->nombre ?? null,
                (float) ($item->saldo_inicial ?? 0),
                (float) ($item->saldo_actual ?? 0),
                $item->deleted_at ? (string)$item->deleted_at : null,
                $can
            );
        });

        return LaravelCollection::make($mapped->values());
    }
}
