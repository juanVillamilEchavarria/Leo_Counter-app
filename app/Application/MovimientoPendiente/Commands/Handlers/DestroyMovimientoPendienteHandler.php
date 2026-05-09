<?php

namespace App\Application\MovimientoPendiente\Commands\Handlers;

use App\Application\MovimientoPendiente\Commands\DestroyMovimientoPendienteCommand;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteRepositoryContract;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;

/**
 * Handler del comando DestroyMovimientoPendienteCommand.
 * Coordina la eliminacion (soft delete) del agregado MovimientoPendiente
 * delegando la operacion al contrato de repositorio.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class DestroyMovimientoPendienteHandler
{
    public function __construct(
        private MovimientoPendienteRepositoryContract $repository,
    ) {
    }

    public function __invoke(DestroyMovimientoPendienteCommand $command): bool
    {
        return $this->repository->destroy(new MovimientoPendienteId($command->id));
    }
}
