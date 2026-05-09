<?php

namespace App\Application\MovimientoFijo\Commands\Handlers;

use App\Application\MovimientoFijo\Commands\DestroyMovimientoFijoCommand;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoRepositoryContract;
use App\Domains\MovimientoFijo\ValueObjects\MovimientoFijoId;

/**
 * Handler del comando DestroyMovimientoFijoCommand.
 * Coordina la eliminacion del agregado a traves del contrato de repositorio.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class DestroyMovimientoFijoHandler
{
    public function __construct(
        private MovimientoFijoRepositoryContract $repository,
    ) {
    }

    public function __invoke(DestroyMovimientoFijoCommand $command): bool
    {
        return $this->repository->destroy(new MovimientoFijoId($command->id));
    }
}
