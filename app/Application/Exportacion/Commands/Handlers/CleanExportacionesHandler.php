<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Commands\Handlers;

use App\Application\Exportacion\Commands\CleanExportacionesCommand;
use App\Application\Exportacion\Commands\DestroyExportacionCommand;
use App\Application\Exportacion\Queries\ListOldExportacionesQuery;
use App\Domains\Exportacion\Aggregate\Exportacion;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Handler que orquesta la limpieza de exportaciones antiguas:
 * obtiene los registros con 6 meses o más de antigüedad y despacha
 * un comando de eliminación por cada uno.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class CleanExportacionesHandler
{
    public function __construct(
        private QueryBus $queryBus,
        private CommandBus $commandBus
    ) {}

    public function __invoke(CleanExportacionesCommand $command): void
    {
        /** @var CollectionContract<Exportacion> $exportaciones */
        $exportaciones = $this->queryBus->ask(new ListOldExportacionesQuery);

        foreach ($exportaciones->getItems() as $exportacion) {
            $this->commandBus->dispatch(new DestroyExportacionCommand($exportacion));
        }
    }
}
