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

use App\Application\Exportacion\Commands\DestroyExportacionCommand;
use App\Application\Exportacion\Contracts\Repositories\ExportacionRepositoryContract;

/**
 * Handler que elimina un registro de exportación persistido.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class DestroyExportacionHandler
{
    public function __construct(
        private ExportacionRepositoryContract $repository
    ) {}

    public function __invoke(DestroyExportacionCommand $command): bool
    {
        return $this->repository->destroy($command->exportacion->getId());
    }
}
