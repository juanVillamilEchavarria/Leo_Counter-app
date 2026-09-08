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

use App\Application\Auditoria\Commands\DestroyAuditoriaCommand;
use App\Domains\Auditoria\Contracts\Repositories\AuditoriaRepositoryContract;

/**
 * Handler que elimina un registro de auditoría persistido.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class DestroyAuditoriaHandler
{
    public function __construct(
        private AuditoriaRepositoryContract $repository
    ) {}

    public function __invoke(DestroyAuditoriaCommand $command): bool
    {
        return $this->repository->destroy($command->auditoria->getId());
    }
}
