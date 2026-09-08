<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Auditoria\Commands\Handlers;

use App\Application\Auditoria\Commands\CleanAuditoriasCommand;
use App\Application\Auditoria\Commands\DestroyAuditoriaCommand;
use App\Application\Auditoria\Queries\ListOldAuditoriasQuery;
use App\Domains\Auditoria\Aggregates\Auditoria;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Handler que orquesta la limpieza de auditorías antiguas:
 * obtiene los registros con 6 meses o más de antigüedad y despacha
 * un comando de eliminación por cada uno.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class CleanAuditoriasHandler
{
    public function __construct(
        private QueryBus $queryBus,
        private CommandBus $commandBus
    ) {}

    public function __invoke(CleanAuditoriasCommand $command): void
    {
        /** @var CollectionContract<Auditoria> $auditorias */
        $auditorias = $this->queryBus->ask(new ListOldAuditoriasQuery);

        foreach ($auditorias->getItems() as $auditoria) {
            $this->commandBus->dispatch(new DestroyAuditoriaCommand($auditoria));
        }
    }
}
